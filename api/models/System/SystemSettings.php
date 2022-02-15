<?php

namespace api\models\System;

use Yii;
use yii\helpers\ArrayHelper;


class SystemSettings
{
    public function fields()
    {
        return [
            'id',
            'name',
            'label',
            'value' => function($model) {
                switch ($model->input_type) {
                    case 'file_manager':
                        return Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->value);
                    default:
                        return $model->value;
                }
            },
        ];
    }
}
