<?php

namespace api\modules\v1\models;

use Yii;
use yii\helpers\ArrayHelper;


trait User
{
    public function fields()
    {
        return [
            'id',
            'username',
            'access_token' => function ($model) {
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
