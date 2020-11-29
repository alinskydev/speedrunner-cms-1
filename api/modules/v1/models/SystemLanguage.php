<?php

namespace api\modules\v1\models;

use Yii;
use yii\helpers\ArrayHelper;


trait SystemLanguage
{
    public function fields()
    {
        return [
            'id',
            'name',
            'code',
            'image' => fn ($model) => Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->image),
            'is_active',
            'is_main',
        ];
    }
}
