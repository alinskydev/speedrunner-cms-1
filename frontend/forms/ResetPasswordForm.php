<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use backend\modules\User\models\User;


class ResetPasswordForm extends Model
{
    private $user;
    public $token;
    
    public $password;
    public $confirm_password;
    
    public function init()
    {
        if (!($this->user = User::findByPasswordResetToken($this->token))) {
            throw new InvalidParamException(Yii::t('app', 'Wrong password reset token'));
        }
        
        return parent::init();
    }
    
    public function rules()
    {
        return [
            [['password', 'confirm_password'], 'required'],
            [['password'], 'string', 'min' => 8, 'max' => 50],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'New password'),
            'confirm_password' => Yii::t('app', 'Confirm password'),
        ];
    }
    
    public function resetPassword()
    {
        $user = $this->user;
        $user->new_password = $this->password;
        $user->password_reset_token = null;
        $user->save();
        
        return Yii::$app->user->login($user, 3600 * 24 * 30);
    }
}
