<?php

namespace backend\modules\User\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class User extends ActiveRecord implements IdentityInterface
{
    public $name;
    public $new_password;
    
    public $profile_attrs = [
        'full_name',
        'phone',
        'address',
        'image',
    ];
    
    public $full_name;
    public $phone;
    public $address;
    public $image;
    
    public static function tableName()
    {
        return 'User';
    }
    
    public function rules()
    {
        return [
            [['username', 'email', 'role', 'full_name'], 'required'],
            [['new_password'], 'required', 'when' => function($model) {
                return $model->isNewRecord;
            }],
            [['username', 'email'], 'unique'],
            [['email'], 'email'],
            [['full_name', 'phone'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
            [['role'], 'in', 'range' => array_keys($this->roles())],
            [['image'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024],
            [['new_password'], 'string', 'min' => 6, 'max' => 50],
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
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'role' => Yii::t('app', 'Role'),
            'email' => Yii::t('app', 'Email'),
            'new_password' => Yii::t('app', 'New password'),
            'full_name' => Yii::t('app', 'Full name'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'image' => Yii::t('app', 'Image'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
    
    static function roles()
    {
        return [
            'admin' => Yii::t('app', 'Admin'),
            'registered' => Yii::t('app', 'Registered'),
        ];
    }
    
    static function itemsList($attr, $type, $q = null, $limit = 20)
    {
        $query = static::find()->joinWith(['profile'])->limit($limit);
        
        switch ($type) {
            case 'self':
                $query->select(['User.id', "User.$attr as text"])->andFilterWhere(['like', "User.$attr", $q]);
                break;
            case 'profile':
                $query->select(['User.id', "UserProfile.$attr as text"])->andFilterWhere(['like', "UserProfile.$attr", $q]);
                break;
        }
        
        return $query;
    }
    
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }
    
    static function find()
    {
        return parent::find()->with(['profile']);
    }
    
    public function afterFind()
    {
        $this->name = $this->username;
        
        foreach ($this->profile_attrs as $p_a) {
            $this->{$p_a} = $this->profile->{$p_a};
        }
        
        return parent::afterFind();
    }

    public function beforeValidate()
    {
        if ($image = UploadedFile::getInstance($this, 'image')) {
            $this->image = $image;
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        if ($this->new_password) {
            $this->generateAuthKey();
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->new_password);
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        IMAGE
        
        $old_image = ArrayHelper::getValue($this->profile, 'image', null);
        
        if ($image = UploadedFile::getInstance($this, 'image')) {
            $this->image = Yii::$app->sr->image->save($image, 'files/profile');
            Yii::$app->sr->file->delete($old_image);
        } else {
            $this->image = $this->image ?: $old_image;
        }
        
        //        PROFILE
        
        $profile = $this->profile ?: new UserProfile;
        $profile->user_id = $this->id;
        
        foreach ($this->profile_attrs as $p_a) {
            $profile->{$p_a} = $this->{$p_a};
        }
        
        $profile->save();
        
        //        ROLE ASSIGN
        
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
        Yii::$app->sr->file->delete($this->image);
        
        $roles = Yii::$app->authManager->getRoles();
        Yii::$app->authManager->revoke($roles[$this->role], $this->id);
        
        return parent::afterDelete();
    }
    
    //        SYSTEM
    
    public static function findIdentity($id)
    {
        return static::find()->where(['id' => $id])->one();
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where(['auth_key' => $token])->one();
    }
    
    public static function findByUsername($username)
    {
        return static::find()->where(['username' => $username])->one();
    }
    
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return false;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }
    
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
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
