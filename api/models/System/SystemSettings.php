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
                switch ($model->type) {
                    case 'file_manager':
                        return Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->value);
                    case 'files':
                        foreach ($model->value as $v) {
                            $result[] = Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($v);
                        }
                        
                        return $result ?? [];
                    case 'groups':
                        return $model->value;
                    default:
                        return $model->value;
                }
            },
        ];
    }
}
