<?php

namespace backend\modules\Blog;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\Blog\controllers';
    public $defaultRoute = 'blog';
    
    public function init()
    {
        parent::init();
    }
}
