<?php

namespace api\modules\v1\models\Staticpage;

use Yii;
use yii\helpers\ArrayHelper;


class StaticpageBlock
{
    public function fields()
    {
        return [
            'name',
            'label',
            'part_name',
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
