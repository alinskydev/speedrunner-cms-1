<?php

namespace api\models\Staticpage;

use Yii;
use yii\helpers\ArrayHelper;


class Staticpage
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
