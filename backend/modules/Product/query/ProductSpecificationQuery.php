<?php

namespace backend\modules\Product\query;

use Yii;
use yii\db\Expression;
use speedrunner\db\ActiveQuery;


class ProductSpecificationQuery extends ActiveQuery
{
    public function byAssignedCategies($categories)
    {
        $lang = Yii::$app->language;
        
        return $this->joinWith([
                'categories',
                'options' => fn ($query) => $query->select(['*', new Expression("product_specification_option.name->>'$.$lang' as name")]),
            ])
            ->andWhere(['product_category.id' => $categories])
            ->select([
                'product_specification.*',
                new Expression("product_specification.name->>'$.$lang' as name"),
                'product_specification_option.sort',
            ])
            ->groupBy('product_specification.id');
    }
}