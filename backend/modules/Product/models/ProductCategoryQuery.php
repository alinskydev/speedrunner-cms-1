<?php

namespace backend\modules\Product\models;

use Yii;
use creocoder\nestedsets\NestedSetsQueryBehavior;


class ProductCategoryQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}
