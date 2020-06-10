<?php

namespace api\modules\v1\models;

use Yii;


class User extends \backend\modules\User\models\User
{
    public function fields()
    {
        return [
            'id',
            'username',
            'access-token' => function ($model) {
                return $model->auth_key;
            },
            'full_name',
            'phone',
            'address',
            'created',
            'updated',
        ];
    }
}
