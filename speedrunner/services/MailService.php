<?php

namespace speedrunner\services;

use Yii;
use yii\swiftmailer\Mailer;


class MailService
{
    private $dir = '@common/mail';
    
    public function send($email, $subject, $view, $data = null)
    {
        $lang = Yii::$app->language;
        $lang = is_dir(Yii::getAlias("$this->dir/html/$lang")) ? $lang : 'en';
        $view = "$this->dir/html/$lang/$view";
        
        $message = Yii::$app->controller->renderPartial($view, ['data' => $data]);
        
        $mailer = new Mailer([
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'localhost',
                'username' => 'noreply@local.host',
                'password' => 'password',
                'port' => '587', // Port 25 is a very common port too
            ],
        ]);
        
        return $mailer->compose()
            ->setFrom(['noreply@local.host' => Yii::$app->services->settings->site_name])
            ->setTo($email)
            ->setSubject($subject)
            ->setHtmlBody($message)
            ->send();
    }
    
    public function changeDir($dir)
    {
        $this->dir = $dir;
    }
}
