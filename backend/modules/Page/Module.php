<?php

namespace backend\modules\Page;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Page\controllers';
    public $defaultRoute = 'page';
    
    public function init()
    {
        parent::init();
    }
}
