<?php

namespace backend\modules\Product\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class ProductCategoryTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductCategoryTranslation';
    }
}
