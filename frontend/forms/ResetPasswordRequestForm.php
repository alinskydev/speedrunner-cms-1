<?php

namespace frontend\forms;

use Yii;
use speedrunner\base\Model;
use backend\modules\User\models\User;


class ResetPasswordRequestForm extends Model
{
    public $email;
    
    public function prepareRules()
    {
        return [
            'email' => [
                ['required'],
                ['email'],
                [
                    'exist',
                    'targetClass' => User::className(),
                    'message' => Yii::t('app', 'There is no user with this email address'),
                ],
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
        $password_reset_token = Yii::$app->helpers->string->randomize() . '_' . time();
        
        $user = User::find()->andWhere(['email' => $this->email])->one();
        $user->updateAttributes(['password_reset_token' => $password_reset_token]);
        
        return Yii::$app->services->mail->send([$user->email], Yii::t('app_email', 'Password reset'), 'password_reset', [
            'token' => $password_reset_token,
        ]);
    }
}
