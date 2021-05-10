<?php

namespace backend\modules\Product\search;

use Yii;
use yii\base\Model;

use backend\modules\Product\models\ProductBrand;


class ProductBrandSearch extends ProductBrand
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
            [['id'], 'integer'],
            [['name', 'slug', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = ProductBrand::find();
        
        $attribute_groups = [
            'match' => ['id'],
            'like' => ['name', 'slug', 'created_at', 'updated_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
