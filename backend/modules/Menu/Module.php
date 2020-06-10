<?php

namespace backend\modules\Menu;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Menu\controllers';
    public $defaultRoute = 'menu';
    
    public function init()
    {
        parent::init();
    }
}
