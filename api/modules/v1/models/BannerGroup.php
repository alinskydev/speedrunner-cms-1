<?php

namespace api\modules\v1\models;

use Yii;
use yii\helpers\ArrayHelper;


trait BannerGroup
{
    public function fields()
    {
        return [
            'text_1',
            'text_2',
            'text_3',
            'link',
            'image' => function ($model) {
                return Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->image);
            },
        ];
    }
}
