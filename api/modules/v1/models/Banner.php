<?php

namespace api\modules\v1\models;

use Yii;
use yii\helpers\ArrayHelper;


trait Banner
{
    public function fields()
    {
        return [
            'id',
            'location',
            'groups',
        ];
    }
}
