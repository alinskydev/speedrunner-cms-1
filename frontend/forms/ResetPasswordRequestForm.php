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
            [['email'], 'exist', 'targetClass' => '\backend\modules\User\models\User', 'message' => Yii::t('app', 'There is no user with this email address')],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'E-mail'),
        ];
    }
    
    public function sendEmail()
    {
        if (!($user = User::findOne(['email' => $this->email]))) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            
            if (!$user->save()) {
                return false;
            }
        }
        
        $data['url'] = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
        
        return Yii::$app->sr->mail->send($user->email, Yii::t('email', 'Password reset'), 'password_reset', $data);
    }
}
