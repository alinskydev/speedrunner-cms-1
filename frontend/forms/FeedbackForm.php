<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;


class FeedbackForm extends Model
{
    public $full_name;
    public $email;
    public $phone;
    public $message;
    
    public function rules()
    {
        return [
            [['full_name', 'email', 'message'], 'required'],
            [['full_name', 'email', 'phone'], 'string', 'max' => 100],
            [['message'], 'string', 'max' => 1000],
            [['email'], 'email'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'full_name' => Yii::t('app', 'Full name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'message' => Yii::t('app', 'Message'),
        ];
    }
    
    public function sendEmail()
    {
        if (!($admin_email = Yii::$app->services->settings->admin_email)) {
            return false;
        }
        
        $data = [];
        
        foreach ($this->attributes as $key => $a) {
            $data[$key] = [
                'label' => $this->getAttributeLabel($key),
                'value' => $a
            ];
        }
        
        return Yii::$app->services->mail->send($admin_email, Yii::t('app_mail', 'Feedback'), 'feedback', $data);
    }
}
