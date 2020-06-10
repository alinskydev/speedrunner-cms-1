<?php

namespace api\modules\v1;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';
    public $defaultRoute = 'settings';
    
    
    public function init()
    {
        parent::init();
    }
}
