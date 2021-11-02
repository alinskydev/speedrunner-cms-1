<?php

namespace frontend\forms;

use Yii;
use speedrunner\base\Model;


class FeedbackForm extends Model
{
    public $full_name;
    public $email;
    public $phone;
    public $message;
    
    public function prepareRules()
    {
        return [
            'full_name' => [
                ['required'],
                ['string', 'max' => 100],
            ],
            'email' => [
                ['required'],
                ['email'],
                ['string', 'max' => 100],
            ],
            'phone' => [
                ['string', 'max' => 100],
            ],
            'message' => [
                ['required'],
                ['string', 'max' => 1000],
            ],
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
        
        return Yii::$app->services->mail->send([$admin_email], Yii::t('app_mail', 'Feedback'), 'feedback', $data);
    }
}
