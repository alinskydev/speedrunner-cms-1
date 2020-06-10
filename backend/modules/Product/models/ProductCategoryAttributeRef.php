<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;


class ProductCategoryAttributeRef extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductCategoryAttributeRef';
    }
}
