<?php

namespace backend\modules\Order\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\Product;


class OrderProduct extends ActiveRecord
{
    public static function tableName()
    {
        return 'OrderProduct';
    }
    
    public function rules()
    {
        return [
            [['price', 'quantity', 'total_price'], 'required'],
            [['price', 'quantity', 'total_price'], 'integer', 'min' => 1],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'order_id' => Yii::t('app', 'Order'),
            'product_id' => Yii::t('app', 'Product'),
            'product_json' => Yii::t('app', 'Product'),
            'price' => Yii::t('app', 'Price'),
            'quantity' => Yii::t('app', 'Quantity'),
            'total_price' => Yii::t('app', 'Total price'),
        ];
    }
    
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
    
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    
    public function afterDelete()
    {
        $product = $this->product;
        $product->updateAttributes(['quantity' => $product->quantity + $this->quantity]);

        return parent::afterDelete();
    }
}
