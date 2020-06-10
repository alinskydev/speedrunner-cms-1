<?php

namespace backend\modules\User;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\User\controllers';
    public $defaultRoute = 'user';
    
    public function init()
    {
        parent::init();
    }
}
