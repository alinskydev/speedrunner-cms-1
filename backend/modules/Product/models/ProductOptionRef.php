<?php

namespace backend\modules\Product\models;

use Yii;
use speedrunner\db\ActiveRecord;


class ProductOptionRef extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductOptionRef';
    }
}
