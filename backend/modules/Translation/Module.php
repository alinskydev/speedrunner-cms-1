<?php

namespace backend\modules\Translation;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Translation\controllers';
    public $defaultRoute = 'source';
    
    public function init()
    {
        parent::init();
    }
}
