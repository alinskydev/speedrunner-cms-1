<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use backend\modules\User\models\User;


class LoginForm extends Model
{
    private $user;
    
    public $username;
    public $password;
    public $remember_me = true;
    
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['remember_me'], 'boolean'],
            [['password'], 'passwordValidation'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'remember_me' => Yii::t('app', 'Remember me'),
        ];
    }
    
    public function passwordValidation($attribute, $params)
    {
        $this->user = User::findByUsername($this->username);
        
        if (!$this->user || !$this->user->validatePassword($this->{$attribute})) {
            $this->addError($attribute, Yii::t('app', 'Incorrect {attribute}', ['attribute' => $this->getAttributeLabel('password')]));
        }
    }
    
    public function login()
    {
        Yii::$app->user->login($this->user, $this->remember_me ? 3600 * 24 * 30 : 0);
        return $this->user;
    }
}
