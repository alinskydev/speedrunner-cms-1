<?php

namespace api\modules\v1\models;

use Yii;
use yii\helpers\ArrayHelper;


trait StaticpageBlock
{
    public function fields()
    {
        return [
            'name',
            'label',
            'part_name',
            'value' => function ($model) {
                switch ($model->type) {
                    case 'images':
                        foreach ($model->value as $v) {
                            $result[] = Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($v);
                        }
                        
                        return isset($result) ? $result : [];
                    case 'groups':
                        return $model->value;
                    default:
                        return $model->value;
                }
            },
        ];
    }
}
