<?php

namespace backend\modules\Block;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Block\controllers';
    public $defaultRoute = 'block';
    
    public function init()
    {
        parent::init();
    }
}
