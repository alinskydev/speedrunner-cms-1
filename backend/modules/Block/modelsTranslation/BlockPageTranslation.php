<?php

namespace backend\modules\Block\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class BlockPageTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlockPageTranslation';
    }
}
