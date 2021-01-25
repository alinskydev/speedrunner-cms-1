<?php

namespace api\modules\v1\models\blog;

use Yii;
use yii\helpers\ArrayHelper;


trait Blog
{
    public function fields()
    {
        return [
            'id',
            'name',
            'short_description',
            'full_description',
            'image' => fn ($model) => $model->image ? Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->image) : null,
            'created',
        ];
    }
}
