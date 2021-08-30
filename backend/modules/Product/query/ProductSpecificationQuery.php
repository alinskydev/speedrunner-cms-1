<?php

namespace backend\modules\Product\query;

use Yii;
use yii\db\Expression;
use speedrunner\db\ActiveQuery;


class ProductSpecificationQuery extends ActiveQuery
{
    public function byAssignedCategies($categories)
    {
        return $this->joinWith([
                'categories',
                'options' => fn($query) => $query->asObject(),
            ])
            ->andWhere(['product_category.id' => $categories])
            ->groupBy('product_specification.id');
    }
}