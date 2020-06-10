<?php

namespace backend\modules\System;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\System\controllers';
    public $defaultRoute = 'settings/update';
    
    public function init()
    {
        parent::init();
    }
}
