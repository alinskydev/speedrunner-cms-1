<?php

namespace frontend\forms;

use Yii;
use speedrunner\base\Model;
use speedrunner\validators\SlugValidator;

use backend\modules\User\models\User;


class SignupForm extends Model
{
    public $username;
    public $email;
    public $full_name;
    public $phone;
    public $password;
    public $confirm_password;
    
    public function prepareRules()
    {
        return [
            'username' => [
                ['required'],
                ['string', 'max' => 100],
                ['unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'This username has already been taken')],
                ['match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => Yii::t('app', 'Field must contain only alphabet chars and digits')],
            ],
            'email' => [
                ['required'],
                ['email'],
                ['string', 'max' => 100],
                ['unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'This email has already been taken')],
            ],
            'full_name' => [
                ['required'],
                ['string', 'max' => 100],
            ],
            'phone' => [
                ['string', 'max' => 100],
            ],
            'password' => [
                ['required'],
                ['string', 'min' => 8, 'max' => 50],
            ],
            'confirm_password' => [
                ['required'],
                ['compare', 'compareAttribute' => 'password'],
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'full_name' => Yii::t('app', 'Full name'),
            'phone' => Yii::t('app', 'Phone'),
            'password' => Yii::t('app', 'Password'),
            'confirm_password' => Yii::t('app', 'Confirm password'),
        ];
    }
    
    public function signup()
    {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->new_password = $this->password;
        
        $user->full_name = $this->full_name;
        $user->phone = $this->phone;
        
        if ($user->save()) {
            Yii::$app->user->login($user);
            return $user;
        } else {
            return false;
        }
    }
}
