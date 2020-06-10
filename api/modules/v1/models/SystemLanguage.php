<?php

namespace api\modules\v1\models;

use Yii;


class SystemLanguage extends \backend\modules\System\models\SystemLanguage
{
    public function fields()
    {
        return [
            'id',
            'name',
            'code',
            'image' => function ($model) {
                return Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->image);
            },
            'is_main' => function ($model) {
                return $model->weight;
            },
            'active',
        ];
    }
}
