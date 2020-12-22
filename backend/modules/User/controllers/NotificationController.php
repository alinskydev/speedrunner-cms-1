<?php

namespace backend\modules\User\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\modules\User\models\UserNotification;


class NotificationController extends Controller
{
    public function actionView($id)
    {
        $model = UserNotification::findOne($id);
        
        if (!$model || $model->user_id != Yii::$app->user->id) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $model->delete();
        return $this->redirect(ArrayHelper::getValue($model->actionType(), 'url'));
    }
    
    public function actionClear()
    {
        UserNotification::deleteAll(['user_id' => Yii::$app->user->id]);
        Yii::$app->session->addFlash('success', Yii::t('app', 'All notifications removed'));
        
        return $this->redirect(Yii::$app->request->referrer);
    }
}
