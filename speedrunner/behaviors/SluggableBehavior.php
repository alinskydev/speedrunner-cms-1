<?php

namespace speedrunner\behaviors;

use Yii;
use yii\helpers\ArrayHelper;


class SluggableBehavior extends \yii\behaviors\SluggableBehavior
{
    public $is_translateable;
    public $attribute = 'name';
    
    public function init()
    {
        $lang = Yii::$app->language;
        
        $this->attribute = $this->is_translateable ? "$this->attribute.$lang" : $this->attribute;
        $this->immutable = $this->immutable ?: true;
        
        return parent::init();
    }
}
