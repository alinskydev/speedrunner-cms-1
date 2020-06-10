<?php

namespace backend\modules\Product\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class ProductAttributeOptionTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductAttributeOptionTranslation';
    }
}
