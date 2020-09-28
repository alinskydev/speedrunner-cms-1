<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;


class ProductCategoryRef extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductCategoryRef';
    }
    
    public function rules()
    {
        return [
            [['product_id', 'category_id'], 'required'],
            
            [['product_id'], 'exist', 'targetClass' => Product::className(), 'targetAttribute' => 'id'],
            [['category_id'], 'exist', 'targetClass' => ProductCategory::className(), 'targetAttribute' => 'id'],
        ];
    }
}
