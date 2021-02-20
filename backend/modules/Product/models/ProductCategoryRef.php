<?php

namespace backend\modules\Product\models;

use Yii;
use speedrunner\db\ActiveRecord;


class ProductCategoryRef extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%product_category_ref}}';
    }
}
