<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use backend\modules\User\models\User;


class ResetPasswordRequestForm extends Model
{
    public $email;
    
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [
                ['email'],
                'exist',
                'targetClass' => '\backend\modules\User\models\User', 'message' => Yii::t('app', 'There is no user with this email address')
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
        ];
    }
    
    public function sendEmail()
    {
        $password_reset_token = Yii::$app->helpers->string->randomize();
        
        $user = User::find()->andWhere(['email' => $this->email])->one();
        $user->updateAttributes(['password_reset_token' => $password_reset_token]);
        
        return Yii::$app->services->mail->send([$user->email], Yii::t('app_email', 'Password reset'), 'password_reset', [
            'token' => $password_reset_token,
        ]);
    }
}
