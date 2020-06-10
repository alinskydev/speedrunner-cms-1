<?php

namespace backend\modules\SpeedRunner;

use Yii;
use yii\web\ForbiddenHttpException;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\SpeedRunner\controllers';
    public $defaultRoute = 'speedrunner';
    public $allowedIPs = ['127.0.0.1', '::1'];
    
    public function init()
    {
        parent::init();
        
        if (Yii::$app instanceof \yii\web\Application && !$this->checkAccess()) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
    }
    
    
    protected function checkAccess()
    {
        $ip = Yii::$app->getRequest()->getUserIP();
        
        foreach ($this->allowedIPs as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
                return true;
            }
        }
        
        Yii::warning('Access is denied due to IP address restriction.', __METHOD__);

        return false;
    }
}
