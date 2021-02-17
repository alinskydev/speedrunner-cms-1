<?php

namespace backend\modules\User\services;

use Yii;
use yii\helpers\ArrayHelper;
use speedrunner\services\ActiveService;

use backend\modules\User\models\UserNotification;


class UserNotificationService extends ActiveService
{
    public function __construct(?UserNotification $model = null)
    {
        $this->model = $model ?? new UserNotification();
    }
    
    public static function create($user_ids, $action_type, $action_id, $params = [])
    {
        foreach ($user_ids as $user_id) {
            $model = new UserNotification;
            $model->user_id = $user_id;
            $model->action_type = $action_type;
            $model->action_id = $action_id;
            $model->params = $params;
            $model->save();
        }
    }
    
    public function actionData()
    {
        switch ($this->model->action_type) {
            case 'order_created':
                return [
                    'label' => Yii::t('app_notification', 'You have new order'),
                    'url' => ['/order/order/index', 'OrderSearch[id]' => $this->model->action_id],
                ];
        }
    }
}