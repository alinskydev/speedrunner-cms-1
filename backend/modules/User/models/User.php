<?php

namespace backend\modules\User\models;

use Yii;
use common\framework\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\services\FileService;


class User extends ActiveRecord implements IdentityInterface
{
    use \api\modules\v1\models\user\User;
    
    const PASSWORD_RESET_TOKEN_EXPIRE = 3600;
    
    public $new_password;
    
    public $profile_attributes = [
        'full_name',
        'phone',
        'address',
    ];
    
    public $full_name;
    public $phone;
    public $address;
    
    public static function tableName()
    {
        return 'User';
    }
    
    public function behaviors()
    {
        return [
            'file' => [
                'class' => \common\behaviors\FileBehavior::className(),
                'attributes' => ['image'],
                'multiple' => false,
                'save_dir' => 'files/profile',
            ],
            'relations_one_one' => [
                'class' => \common\behaviors\RelationBehavior::className(),
                'type' => 'oneOne',
                'attributes' => [
                    'profile' => [
                        'model' => new UserProfile(),
                        'relation' => 'profile',
                        'attributes' => [
                            'main' => 'user_id',
                            'relational' => $this->profile_attributes,
                        ],
                    ],
                ],
            ],
            'log_actions' => [
                'class' => \common\behaviors\LogActionBehavior::className(),
                'exclude_attributes' => ['auth_key', 'password_hash', 'password_reset_token', 'user_id'],
                'relations_one_one' => [
                    'profile' => [
                        'relation' => 'profile',
                        'attributes' => $this->profile_attributes,
                    ],
                ],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['username', 'email', 'role', 'full_name'], 'required'],
            [['new_password'], 'required', 'when' => function($model) {
                return $model->isNewRecord;
            }],
            
            [['username', 'email'], 'unique'],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => Yii::t('app', 'Field must contain only alphabet and numerical chars')],
            [['username', 'full_name', 'phone'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 1000],
            [['email'], 'email'],
            [['role'], 'in', 'range' => array_keys($this->roles())],
            [['image'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024],
            [['new_password'], 'string', 'min' => 8, 'max' => 50],
            
            [['design_theme'], 'in', 'range' => array_keys($this->designThemes())],
            [['design_font'], 'in', 'range' => array_keys($this->designFonts())],
            [['design_border_radius'], 'integer', 'min' => 0],
            [['design_border_radius'], 'default', 'value' => 0],
            
            [['role'], 'adminRoleValidation'],
        ];
    }
    
    public function adminRoleValidation($attribute, $params, $validator)
    {
        if ($this->id == 1 && $this->role != 'admin') {
            $this->addError($attribute, Yii::t('app', 'You cannot change role for this user'));
        }
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'username' => Yii::t('app', 'Username'),
            'role' => Yii::t('app', 'Role'),
            'email' => Yii::t('app', 'Email'),
            'image' => Yii::t('app', 'Image'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            
            'design_theme' => Yii::t('app', 'Theme'),
            'design_font' => Yii::t('app', 'Font'),
            'design_border_radius' => Yii::t('app', 'Border radius'),
            
            'new_password' => Yii::t('app', 'New password'),
            
            'full_name' => Yii::t('app', 'Full name'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
        ];
    }
    
    public static function roles()
    {
        return [
            'admin' => [
                'label' => Yii::t('app', 'Admin'),
            ],
            'registered' => [
                'label' => Yii::t('app', 'Registered'),
            ],
        ];
    }
    
    public static function designThemes()
    {
        return [
            'nav_full' => [
                'label' => Yii::t('app', 'Full menu'),
            ],
            'nav_left' => [
                'label' => Yii::t('app', 'Left menu'),
            ],
        ];
    }
    
    public static function designFonts()
    {
        return [
            'oswald' => [
                'label' => 'Oswald',
            ],
            'roboto' => [
                'label' => 'Roboto',
            ],
            'montserrat' => [
                'label' => 'Montserrat',
            ],
            'ibm_plex_sans' => [
                'label' => 'IBM Plex Sans',
            ],
        ];
    }
    
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }
    
    public static function find()
    {
        return new \backend\modules\User\models\query\UserQuery(get_called_class());
    }
    
    public function afterFind()
    {
        foreach ($this->profile_attributes as $p_a) {
            $this->{$p_a} = $this->profile->{$p_a};
        }
        
        return parent::afterFind();
    }
    
    public function beforeSave($insert)
    {
        //        New password
        
        if ($this->new_password) {
            $this->generateAuthKey();
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->new_password);
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        Role assigning
        
        if (array_key_exists('role', $changedAttributes)) {
            $roles = Yii::$app->authManager->getRoles();
            
            if (!$insert) {
                Yii::$app->authManager->revoke($roles[$changedAttributes['role']], $this->id);
            }
            
            Yii::$app->authManager->assign($roles[$this->role], $this->id);
            Yii::$app->authManager->invalidateCache();
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function beforeDelete()
    {
        if ($this->id == 1) {
            Yii::$app->session->addFlash('danger', Yii::t('app', 'You cannot delete this record'));
            return false;
        }
        
        return parent::beforeDelete();
    }
    
    public function afterDelete()
    {
        $roles = Yii::$app->authManager->getRoles();
        Yii::$app->authManager->revoke($roles[$this->role], $this->id);
        
        return parent::afterDelete();
    }
    
    //        YII2 default methods
    
    public static function findIdentity($id)
    {
        return static::find()->andWhere(['id' => $id])->one();
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->andWhere(['auth_key' => $token])->one();
    }
    
    public static function findByUsername($username)
    {
        return static::find()->andWhere(['username' => $username])->one();
    }
    
    public static function findByPasswordResetToken($token)
    {
        return static::isPasswordResetTokenValid($token) ? static::findOne(['password_reset_token' => $token]) : false;
    }
    
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = static::PASSWORD_RESET_TOKEN_EXPIRE;
        return $timestamp + $expire >= time();
    }
    
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
