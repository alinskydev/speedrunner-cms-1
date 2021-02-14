<?php

namespace backend\modules\Product\models;

use Yii;
use speedrunner\db\ActiveRecord;


class ProductRelatedRef extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductRelatedRef';
    }
}
