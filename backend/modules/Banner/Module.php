<?php

namespace backend\modules\Banner;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Banner\controllers';
    public $defaultRoute = 'banner';
    
    public function init()
    {
        parent::init();
    }
}
