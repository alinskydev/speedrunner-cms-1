<?php

namespace backend\modules\Log;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Log\controllers';
    public $defaultRoute = 'action';
    
    public function init()
    {
        parent::init();
    }
}
