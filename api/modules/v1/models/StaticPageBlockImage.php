<?php

namespace api\modules\v1\models;

use Yii;


class StaticPageBlockImage extends \backend\modules\StaticPage\models\StaticPageBlockImage
{
    public function fields()
    {
        return [
            'image' => function ($model) {
                return Yii::$app->urlManagerFrontend->createAbsoluteFileUrl([$model->image]);
            },
        ];
    }
}
