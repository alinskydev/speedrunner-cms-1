<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;


class ProductCategoryRef extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductCategoryRef';
    }
}
