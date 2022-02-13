<?php

namespace api\models\User;

use Yii;
use yii\helpers\ArrayHelper;


class User
{
    public function fields()
    {
        return [
            'id',
            'username',
            'access_token' => fn($model) => $model->auth_key,
            'full_name',
            'phone',
            'address',
            'image' => fn($model) => $model->image ? Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->image) : null,
            'created_at',
            'updated_at',
        ];
    }
}
