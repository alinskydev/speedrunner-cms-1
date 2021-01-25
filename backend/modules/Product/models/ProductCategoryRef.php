<?php

namespace backend\modules\Product\models;

use Yii;
use common\framework\ActiveRecord;


class ProductCategoryRef extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductCategoryRef';
    }
}
