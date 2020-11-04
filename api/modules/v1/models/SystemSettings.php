<?php

namespace api\modules\v1\models;

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
            'value',
        ];
    }
}
