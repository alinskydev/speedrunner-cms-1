<?php

namespace api\modules\v1\models\system;

use Yii;
use yii\helpers\ArrayHelper;


trait SystemSettings
{
    public function fields()
    {
        return [
            'id',
            'name',
            'label',
            'value' => function ($model) {
                switch ($model->type) {
                    case 'ElFinder':
                        return Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->value);
                    case 'images':
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
