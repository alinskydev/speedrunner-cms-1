<?php

namespace api\modules\v1\models;

use Yii;
use yii\helpers\ArrayHelper;


trait Staticpage
{
    public function fields()
    {
        return [
            'id',
            'name',
            'label',
            'blocks',
        ];
    }
}
