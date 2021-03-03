<?php

namespace backend\modules\User\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use speedrunner\validators\UnchangeableValidator;
use yii\web\UploadedFile;
use speedrunner\services\FileService;


class User extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_UPDATE_PROFILE = 'update_profile';
    
    const PASSWORD_RESET_TOKEN_EXPIRE = 3600;
    
    public $new_password;
    
    public $full_name;
    public $phone;
    public $address;
    
    public $design_theme;
    public $design_font;
    public $design_border_radius;
    
    public $profile_attributes = [
        'full_name',
        'phone',
        'address',
    ];
    
    public $design_attributes = [
        'design_theme',
        'design_font',
        'design_border_radius',
    ];
    
    public static function tableName()
    {
        return '{{%user}}';
    }
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE_PROFILE] = [
            'new_password', 'full_name', 'phone', 'address',
            'design_theme', 'design_font', 'design_border_radius',
        ];
        
        return $scenarios;
    }
    
    public function behaviors()
    {
        return [
            'file' => [
                'class' => \speedrunner\behaviors\FileBehavior::className(),
                'attributes' => ['image'],
                'multiple' => false,
                'save_dir' => 'files/profile',
            ],
            'relations_one_one' => [
                'class' => \speedrunner\behaviors\RelationBehavior::className(),
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
                    'design' => [
                        'model' => new UserDesign(),
                        'relation' => 'design',
                        'attributes' => [
                            'main' => 'user_id',
                            'relational' => $this->design_attributes,
                        ],
                    ],
                ],
            ],
            'log_actions' => [
                'class' => \speedrunner\behaviors\LogActionBehavior::className(),
                'exclude_attributes' => ['auth_key', 'password_hash', 'password_reset_token', 'user_id'],
                'relations_one_one' => [
                    'profile' => [
                        'relation' => 'profile',
                        'attributes' => $this->profile_attributes,
                    ],
                    'design' => [
                        'relation' => 'design',
                        'attributes' => $this->design_attributes,
                    ],
                ],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['username', 'email', 'role', 'full_name'], 'required'],
            [['new_password'], 'required', 'enableClientValidation' => false, 'when' => function($model) {
                return $model->isNewRecord;
            }],
            
            [['username', 'email'], 'unique'],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => Yii::t('app', 'Field must contain only alphabet and numerical chars')],
            [['username', 'full_name', 'phone'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 1000],
            [['email'], 'email'],
            [['role'], 'in', 'range' => array_keys($this->enums->roles())],
            [['image'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024],
            [['new_password'], 'string', 'min' => 8, 'max' => 50],
            
            [['design_theme'], 'in', 'range' => array_keys($this->enums->designThemes())],
            [['design_font'], 'in', 'range' => array_keys($this->enums->designFonts())],
            [['design_border_radius'], 'integer', 'min' => 0],
            [['design_border_radius'], 'default', 'value' => 0],
            
            [['role'], UnchangeableValidator::className(), 'when' => fn ($model) => $model->id == 1],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'username' => Yii::t('app', 'Username'),
            'role' => Yii::t('app', 'Role'),
            'email' => Yii::t('app', 'Email'),
            'image' => Yii::t('app', 'Image'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            
            'new_password' => Yii::t('app', 'New password'),
            
            'full_name' => Yii::t('app', 'Full name'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            
            'design_theme' => Yii::t('app', 'Theme'),
            'design_font' => Yii::t('app', 'Font'),
            'design_border_radius' => Yii::t('app', 'Border radius'),
        ];
    }
    
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }
    
    public function getDesign()
    {
        return $this->hasOne(UserDesign::className(), ['user_id' => 'id']);
    }
    
    public function afterFind()
    {
        foreach ($this->profile_attributes as $p_a) {
            $this->{$p_a} = $this->profile->{$p_a};
        }
        
        foreach ($this->design_attributes as $p_a) {
            $this->{$p_a} = $this->design->{$p_a};
        }
        
        return parent::afterFind();
    }
    
    public function beforeSave($insert)
    {
        //        Setting new password
        
        if ($this->new_password) {
            $this->generateAuthKey();
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->new_password);
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        Assigning role
        
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
        //        Detaching role
        
        $roles = Yii::$app->authManager->getRoles();
        Yii::$app->authManager->revoke($roles[$this->role], $this->id);
        
        return parent::afterDelete();
    }
    
    //        YII2 default methods
    
    public static function findIdentity($id)
    {
        return self::find()->andWhere(['id' => $id])->one();
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()->andWhere(['auth_key' => $token])->one();
    }
    
    public static function findByUsername($username)
    {
        return self::find()->andWhere(['username' => $username])->one();
    }
    
    public static function findByPasswordResetToken($token)
    {
        return self::isPasswordResetTokenValid($token) ? self::findOne(['password_reset_token' => $token]) : false;
    }
    
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = self::PASSWORD_RESET_TOKEN_EXPIRE;
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
