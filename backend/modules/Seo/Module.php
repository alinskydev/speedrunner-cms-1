<?php

namespace backend\modules\Seo;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Seo\controllers';
    public $defaultRoute = 'meta';
    
    public function init()
    {
        parent::init();
    }
}
