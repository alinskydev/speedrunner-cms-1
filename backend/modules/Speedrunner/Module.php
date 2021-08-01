<?php

namespace backend\modules\Speedrunner;

use Yii;
use yii\web\ForbiddenHttpException;


class Module extends \yii\base\Module
{
    public $defaultRoute = 'speedrunner';
    
    public function beforeAction($action)
    {
        if (!in_array(Yii::$app->request->userIP, Yii::$app->params['debug_ips'])) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
        
        return parent::beforeAction($action);
    }
}
