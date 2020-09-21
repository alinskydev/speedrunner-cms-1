<?php

namespace common\helpers;

use Yii;

use common\helpers\Speedrunner\ActiveField;
use common\helpers\Speedrunner\File;
use common\helpers\Speedrunner\Image;
use common\helpers\Speedrunner\Mail;
use common\helpers\Speedrunner\Record;
use common\helpers\Speedrunner\Seo;
use common\helpers\Speedrunner\Translation;


class Speedrunner
{
    public $activeField;
    public $file;
    public $image;
    public $mail;
    public $record;
    public $seo;
    public $translation;
    
    public function __construct()
    {
        $this->activeField = new ActiveField;
        $this->file = new File;
        $this->image = new Image;
        $this->mail = new Mail;
        $this->record = new Record;
        $this->seo = new Seo;
        $this->translation = new Translation;
    }
}
