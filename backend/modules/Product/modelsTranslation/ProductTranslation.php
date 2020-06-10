<?php

namespace backend\modules\Product\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class ProductTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductTranslation';
    }
}
