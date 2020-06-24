<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use backend\modules\User\models\User;


class SignupForm extends Model
{
    public $username;
    public $email;
    public $full_name;
    public $phone;
    public $password;
    public $confirm_password;
    
    public function rules()
    {
        return [
            [['username', 'email', 'full_name', 'password', 'confirm_password'], 'required'],
            [['username'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['email', 'full_name', 'phone'], 'string', 'max' => 100],
            
            [['username'], 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'This username has already been taken.')],
            [['email'], 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'This email has already been taken.')],
            [['password'], 'string', 'min' => 6],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'E-mail'),
            'password' => Yii::t('app', 'Password'),
            'confirm_password' => Yii::t('app', 'Confirm password'),
            
            'full_name' => Yii::t('app', 'Full name'),
            'phone' => Yii::t('app', 'Phone'),
        ];
    }
    
    public function signup()
    {
        $user = new User;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->role = 'registered';
        $user->new_password = $this->password;
        
        $user->full_name = $this->full_name;
        $user->phone = $this->phone;
        
        if ($user->save()) {
            return Yii::$app->user->login($user);
        } else {
            return false;
        }
    }
}
