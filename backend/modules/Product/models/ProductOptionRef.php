<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;


class ProductOptionRef extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductOptionRef';
    }
}
