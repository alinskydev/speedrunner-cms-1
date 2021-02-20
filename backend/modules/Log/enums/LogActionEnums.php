<?php

namespace backend\modules\Log\enums;

use Yii;


class LogActionEnums
{
    public static function types()
    {
        return [
            'created' => [
                'label' => Yii::t('app', 'Created'),
            ],
            'updated' => [
                'label' => Yii::t('app', 'Updated'),
            ],
            'deleted' => [
                'label' => Yii::t('app', 'Deleted'),
            ],
        ];
    }
}
