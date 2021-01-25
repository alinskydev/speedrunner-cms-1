<?php

namespace backend\modules\Product\models;

use Yii;
use common\framework\ActiveRecord;


class ProductCategorySpecificationRef extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductCategorySpecificationRef';
    }
}
