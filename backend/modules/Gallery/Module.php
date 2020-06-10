<?php

namespace backend\modules\Gallery;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Gallery\controllers';
    public $defaultRoute = 'gallery';
    
    public function init()
    {
        parent::init();
    }
}
