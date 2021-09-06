<?php

namespace backend\modules\User\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use speedrunner\validators\UnchangeableValidator;


class User extends ActiveRecord implements IdentityInterface
{
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
        return ArrayHelper::merge(parent::scenarios(), [
            'update_profile' => [
                'full_name', 'phone', 'address', 'new_password',
                'design_theme', 'design_font', 'design_border_radius',
            ],
        ]);
    }
    
    public function behaviors()
    {
        return [
            'file' => [
                'class' => \speedrunner\behaviors\FileBehavior::className(),
                'attributes' => ['image'],
                'multiple' => false,
                'save_dir' => 'uploaded/profile',
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
            [['username', 'email', 'full_name'], 'required'],
            [['new_password'], 'required', 'enableClientValidation' => false, 'when' => fn($model) => $model->isNewRecord],
            
            [['username', 'email'], 'unique'],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => Yii::t('app', 'Field must contain only alphabet and numerical chars')],
            [['username', 'full_name', 'phone'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 1000],
            [['email'], 'email'],
            [['image'], 'file', 'extensions' => Yii::$app->params['extensions']['image'], 'maxSize' => 1024 * 1024],
            [['new_password'], 'string', 'min' => 8, 'max' => 50],
            
            [['design_theme'], 'in', 'range' => array_keys($this->enums->designThemes())],
            [['design_font'], 'in', 'range' => array_keys($this->enums->designFonts())],
            [['design_border_radius'], 'integer', 'min' => 0],
            [['design_theme'], 'default', 'value' => 'nav_left'],
            [['design_font'], 'default', 'value' => 'roboto'],
            [['design_border_radius'], 'default', 'value' => 0],
            
            [['role_id'], 'required', 'enableClientValidation' => false, 'when' => fn($model) => $model->id == 1],
            [['role_id'], 'exist', 'targetClass' => UserRole::className(), 'targetAttribute' => 'id'],
            [['role_id'], UnchangeableValidator::className(), 'when' => fn($model) => $model->id == 1],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'username' => Yii::t('app', 'Username'),
            'role_id' => Yii::t('app', 'Role'),
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
    
    public function getRole()
    {
        return $this->hasOne(UserRole::className(), ['id' => 'role_id']);
    }
    
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }
    
    public function getDesign()
    {
        return $this->hasOne(UserDesign::className(), ['user_id' => 'id']);
    }
    
    public static function find()
    {
        return parent::find()->with(['profile', 'design']);
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
            $this->auth_key = Yii::$app->helpers->string->randomize();
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->new_password);
            Yii::$app->session->set('__authKey', $this->auth_key);
        }
        
        return parent::beforeSave($insert);
    }
    
    public function beforeDelete()
    {
        if ($this->id == 1) {
            Yii::$app->session->addFlash('danger', Yii::t('app', 'You cannot delete this record'));
            return false;
        }
        
        return parent::beforeDelete();
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
}
