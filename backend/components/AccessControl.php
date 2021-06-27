<?php
 
namespace backend\components;
 
use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

use backend\modules\User\helpers\UserRoleHelper;


class AccessControl extends ActionFilter
{
    public $allowed_actions;
    
    public function beforeAction($action)
    {
        //        Common
        
        $route = $action->getUniqueId();
        
        if (in_array($route, $this->allowed_actions)) {
            return parent::beforeAction($action);
        }
        
        if (!($user = Yii::$app->user->identity)) {
            Yii::$app->user->loginRequired();
            return false;
        }
        
        if (!($role = $user->role)) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        
        //        Depending on role
        
        if (!$role->service->isAllowedByRoute($route)) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        
        return parent::beforeAction($action);
    }
}