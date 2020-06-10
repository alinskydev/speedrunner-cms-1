<?php

namespace backend\modules\Product\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class ProductBrandTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductBrandTranslation';
    }
}
