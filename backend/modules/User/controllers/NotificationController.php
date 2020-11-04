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
        
        if (!$model || $model->user_id != Yii::$app->user->identity->id) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $model->delete();
        return $this->redirect(ArrayHelper::getValue($model->actionType(), 'url'));
    }
}
