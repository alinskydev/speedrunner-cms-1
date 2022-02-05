<?php

namespace api\modules\v1\models\Blog;

use Yii;
use yii\helpers\ArrayHelper;


class Blog
{
    public function fields()
    {
        return [
            'id',
            'name',
            'slug',
            'category_id',
            'category',
            'short_description',
            'full_description',
            'image' => fn($model) => $model->image ? Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->image) : null,
            'images' => fn($model) => array_map(fn($value) => Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($value), $model->images),
            'published_at',
            'created_at',
        ];
    }
}
