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
        $this->model = $model;
    }

    public static function create(array $user_ids, $action_type, $action_id, array $params = [])
    {
        $datetime = date('Y-m-d H:i:s');

        foreach ($user_ids as $user_id) {
            $records[] = [
                $user_id,
                $action_type,
                $action_id,
                $params,
                $datetime,
            ];
        }

        $attributes = ['user_id', 'action_type', 'action_id', 'params', 'created_at'];
        Yii::$app->db->createCommand()->batchInsert('user_notification', $attributes, $records ?? [])->execute();
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
