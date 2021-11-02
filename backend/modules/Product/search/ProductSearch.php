<?php

namespace backend\modules\Product\search;

use Yii;
use backend\modules\Product\models\Product;


class ProductSearch extends Product
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['sluggable']);
        
        return $behaviors;
    }
    
    public function rules()
    {
        return [
            [['id', 'price', 'discount', 'brand_id', 'main_category_id', 'quantity'], 'integer'],
            [['name', 'slug', 'sku', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function search()
    {
        $query = Product::find()
            ->with(['brand', 'mainCategory']);
        
        $attribute_groups = [
            '=' => ['id', 'brand_id', 'main_category_id', 'price', 'quantity', 'discount'],
            'like' => ['slug', 'sku', 'created_at', 'updated_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
