<?php

namespace speedrunner\behaviors;

use Yii;
use yii\helpers\ArrayHelper;


class SluggableBehavior extends \yii\behaviors\SluggableBehavior
{
    public function init()
    {
        $this->attribute = $this->attribute ?: 'name';
        $this->immutable = $this->immutable ?: true;
        
        return parent::init();
    }
}
