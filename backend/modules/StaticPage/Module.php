<?php

namespace backend\modules\StaticPage;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\StaticPage\controllers';
    public $defaultRoute = 'static-page';
    
    public function init()
    {
        parent::init();
    }
}
