<?php

namespace backend\modules\User\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

use speedrunner\validators\SlugValidator;
use speedrunner\validators\UnchangeableValidator;


class User extends ActiveRecord implements IdentityInterface
{
    const PASSWORD_RESET_TOKEN_EXPIRE = 3600;
    
    public $new_password;
    
    public $full_name;
    public $phone;
    public $address;
    
    public $profile_attributes = [
        'full_name',
        'phone',
        'address',
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
                ],
            ],
            'log_actions' => [
                'class' => \backend\modules\Log\behaviors\LogActionBehavior::className(),
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
    
    public function prepareRules()
    {
        return [
            'username' => [
                ['required'],
                [SlugValidator::className(), 'message' => Yii::t('app', 'Field must be unique and contain only alphabet chars and digits')],
            ],
            'role_id' => [
                ['required', 'enableClientValidation' => false, 'when' => fn($model) => $model->id == 1],
                ['exist', 'targetClass' => UserRole::className(), 'targetAttribute' => 'id'],
                [UnchangeableValidator::className(), 'when' => fn($model) => $model->id == 1],
            ],
            'email' => [
                ['required'],
                ['unique'],
                ['email'],
            ],
            'image' => [
                ['file', 'extensions' => Yii::$app->params['extensions']['image'], 'maxSize' => 1024 * 1024],
            ],
            'new_password' => [
                ['required', 'enableClientValidation' => false, 'when' => fn($model) => $model->isNewRecord],
                ['string', 'min' => 8, 'max' => 50],
            ],
            'full_name' => [
                ['required'],
                ['string', 'max' => 100],
            ],
            'phone' => [
                ['string', 'max' => 100],
            ],
            'address' => [
                ['string', 'max' => 1000],
            ],
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
    
    public static function find()
    {
        return parent::find()->with(['profile']);
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
            Yii::$app->session->addFlash('danger', Yii::t('app', 'You cannot delete this user'));
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
