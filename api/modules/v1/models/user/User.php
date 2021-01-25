<?php

namespace api\modules\v1\models\user;

use Yii;
use yii\helpers\ArrayHelper;


trait User
{
    public function fields()
    {
        return [
            'id',
            'username',
            'access_token' => fn ($model) => $model->auth_key,
            'full_name',
            'phone',
            'address',
            'image' => fn ($model) => $model->image ? Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->image) : null,
            'created',
            'updated',
        ];
    }
}
