<?php

namespace backend\modules\Product;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Product\controllers';
    public $defaultRoute = 'product';
    
    public function init()
    {
        parent::init();
    }
}
