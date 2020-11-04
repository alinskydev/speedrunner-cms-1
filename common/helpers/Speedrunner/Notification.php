<?php

namespace common\helpers\Speedrunner;

use Yii;
use backend\modules\User\models\UserNotification;


class Notification
{
    public function create($user_ids, $action_type, $action_id, $params = [])
    {
        foreach ($user_ids as $user_id) {
            (new UserNotification(['user_id' => $user_id, 'action_type' => $action_type, 'action_id' => $action_id, 'params' => $params]))->save();
        }
    }
}