<?php

namespace api\models\Blog;

use Yii;
use yii\helpers\ArrayHelper;


class BlogCategory
{
    public function fields()
    {
        return [
            'id',
            'name',
            'image' => fn($model) => $model->image ? Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->image) : null,
        ];
    }
}
