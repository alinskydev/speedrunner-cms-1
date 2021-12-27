<?php

namespace backend\forms;

use Yii;
use speedrunner\base\Model;

use backend\modules\User\models\User;


class LoginForm extends Model
{
    private $user;
    
    public $username;
    public $password;
    public $remember_me = true;
    
    public function prepareRules()
    {
        return [
            'username' => [
                ['required'],
            ],
            'password' => [
                ['required'],
                ['passwordValidation'],
            ],
            'remember_me' => [
                ['boolean'],
            ],
        ];
    }
    
    public function passwordValidation($attribute, $params)
    {
        $this->user = User::find()
            ->andWhere([
                'and',
                ['username' => $this->username],
                'role_id IS NOT NULL',
            ])
            ->one();
        
        if (!$this->user || !$this->user->validatePassword($this->{$attribute})) {
            $this->addError($attribute, Yii::t('app', 'Incorrect {attribute}', ['attribute' => $this->getAttributeLabel('password')]));
        }
    }
    
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'remember_me' => Yii::t('app', 'Remember me'),
        ];
    }
    
    public function login()
    {
        Yii::$app->user->login($this->user, $this->remember_me ? 3600 * 24 * 30 : 0);
        return $this->user;
    }
}
