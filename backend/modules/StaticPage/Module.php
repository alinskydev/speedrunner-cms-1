<?php

namespace backend\modules\Staticpage;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Staticpage\controllers';
    public $defaultRoute = 'staticpage';
    
    public function init()
    {
        parent::init();
    }
}
