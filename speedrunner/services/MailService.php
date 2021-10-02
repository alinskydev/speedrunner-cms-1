<?php

namespace speedrunner\services;

use Yii;
use yii\swiftmailer\Mailer;


class MailService
{
    private $dir = '@common/mail';
    
    public function send(array $emails, $subject, $view, $data = null, $file = null)
    {
        $lang = Yii::$app->language;
        $lang = is_dir(Yii::getAlias("$this->dir/html/$lang")) ? $lang : 'en';
        $view = "$this->dir/html/$lang/$view";
        
        $content = Yii::$app->controller->renderPartial($view, ['data' => $data]);
        
        $mailer = new Mailer([
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'local.host',
                'username' => 'noreply@local.host',
                'password' => 'password',
                'port' => '587', // Port 25 is a very common port too
            ],
        ]);
        
        $message = $mailer->compose()
            ->setFrom(["noreply@{$_SERVER['HTTP_HOST']}" => Yii::$app->services->settings->site_name])
            ->setSubject($subject)
            ->setHtmlBody($content);
        
        if ($file) {
            $message->attach($file['file'], ['fileName' => $file['name']]);
        }
        
        foreach ($emails as $email) {
            if (!$message->setTo($email)->send()) return false;
        }
        
        return true;
    }
    
    public function changeDir($dir)
    {
        $this->dir = $dir;
    }
}
