<?php

namespace backend\modules\Product\search;

use Yii;
use backend\modules\Product\models\ProductSpecification;


class ProductSpecificationSearch extends ProductSpecification
{
    public function rules()
    {
        return [
            [['id', 'show_in_filter', 'show_in_compare'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function search()
    {
        $query = ProductSpecification::find();
        
        $attribute_groups = [
            '=' => ['id', 'show_in_filter', 'show_in_compare'],
            'like' => ['created_at', 'updated_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
