<?php

namespace backend\modules\Speedrunner;

use Yii;
use yii\web\ForbiddenHttpException;


class Module extends \yii\base\Module
{
    public $defaultRoute = 'speedrunner';
    
    public function beforeAction($action)
    {
        if (!Yii::$app->params['is_development_ip']) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        
        return parent::beforeAction($action);
    }
}
