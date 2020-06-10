<?php

namespace api\modules\v1\models;

use Yii;


class SystemSettings extends \backend\modules\System\models\SystemSettings
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
