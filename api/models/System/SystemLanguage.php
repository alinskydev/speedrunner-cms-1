<?php

namespace api\models\System;

use Yii;
use yii\helpers\ArrayHelper;


class SystemLanguage
{
    public function fields()
    {
        return [
            'id',
            'name',
            'code',
            'image' => fn($model) => Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->image),
            'is_active',
            'is_main',
        ];
    }
}
