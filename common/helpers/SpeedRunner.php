<?php

namespace common\helpers;

use Yii;

use common\helpers\SpeedRunner\File;
use common\helpers\SpeedRunner\Image;
use common\helpers\SpeedRunner\Mail;
use common\helpers\SpeedRunner\Record;
use common\helpers\SpeedRunner\Seo;
use common\helpers\SpeedRunner\Translation;


class SpeedRunner
{
    public $file;
    public $image;
    public $mail;
    public $record;
    public $seo;
    public $translation;
    
    public function __construct()
    {
        $this->file = new File;
        $this->image = new Image;
        $this->mail = new Mail;
        $this->record = new Record;
        $this->seo = new Seo;
        $this->translation = new Translation;
    }
}
