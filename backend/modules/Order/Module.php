<?php

namespace backend\modules\Order;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Order\controllers';
    public $defaultRoute = 'order';
    
    public function init()
    {
        parent::init();
    }
}
