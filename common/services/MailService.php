<?php

namespace common\services;

use Yii;


class MailService
{
    private $dir;
    
    public function __construct()
    {
        $this->dir = '@common/mail';
    }
    
    public function send($email, $subject, $view, $data = null)
    {
        $lang = Yii::$app->language;
        $lang = is_dir(Yii::getAlias("$this->dir/html/$lang")) ? $lang : 'en';
        $view = "$this->dir/html/$lang/$view";
        
        $message = Yii::$app->controller->renderPartial($view, ['data' => $data]);
        
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
        $headers .= 'From: <noreply@' . Yii::$app->request->hostName . ">\r\n";
        
        return mail($email, $subject, $message, $headers);
    }
}
