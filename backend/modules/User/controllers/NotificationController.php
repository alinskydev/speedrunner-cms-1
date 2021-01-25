<?php

namespace backend\modules\User\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\modules\User\models\UserNotification;
use backend\modules\User\services\UserNotificationService;


class NotificationController extends Controller
{
    public function actionView($id)
    {
        $model = UserNotification::findOne($id);
        
        if (!$model || $model->user_id != Yii::$app->user->id || !$model->delete()) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $notification_service = new UserNotificationService($model);
        return $this->redirect(ArrayHelper::getValue($notification_service->actionData(), 'url'));
    }
    
    public function actionClear()
    {
        UserNotification::deleteAll(['user_id' => Yii::$app->user->id]);
        Yii::$app->session->addFlash('success', Yii::t('app', 'All notifications removed'));
        
        return $this->redirect(Yii::$app->request->referrer);
    }
}
