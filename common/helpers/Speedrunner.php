<?php

namespace common\helpers;

use Yii;


class Speedrunner
{
    public $file;
    public $html;
    public $image;
    public $mail;
    public $notification;
    public $record;
    public $seo;
    public $translation;
    
    public function __construct()
    {
        $this->file = new \common\helpers\Speedrunner\File();
        $this->html = new \common\helpers\Speedrunner\Html();
        $this->image = new \common\helpers\Speedrunner\Image();
        $this->mail = new \common\helpers\Speedrunner\Mail();
        $this->notification = new \common\helpers\Speedrunner\Notification();
        $this->record = new \common\helpers\Speedrunner\Record();
        $this->seo = new \common\helpers\Speedrunner\Seo();
        $this->translation = new \common\helpers\Speedrunner\Translation();
    }
}
