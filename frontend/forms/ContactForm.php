<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;


class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $message;
    public $verify_code;
    
    public function rules()
    {
        return [
            [['name', 'email', 'message'], 'required'],
            [['name', 'email', 'phone'], 'string', 'max' => 100],
            [['message'], 'string', 'max' => 1000],
            [['email'], 'email'],
            [['verify_code'], 'captcha'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'E-mail'),
            'phone' => Yii::t('app', 'Phone'),
            'message' => Yii::t('app', 'Message'),
            'verify_code' => Yii::t('app', 'Verify code'),
        ];
    }
    
    public function sendEmail()
    {
        if ($admin_email = Yii::$app->settings->admin_email) {
            $data = [];
            
            foreach ($this->attributes as $key => $a) {
                $data[$key] = [
                    'label' => $this->getAttributeLabel($key),
                    'value' => $a
                ];
            }
            
            return Yii::$app->sr->mail->send($admin_email, Yii::t('app', 'Feedback'), 'feedback', $data);
        } else {
            return false;
        }
    }
}
