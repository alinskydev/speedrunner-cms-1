<?php

namespace backend\modules\Order\models;

use Yii;
use common\framework\ActiveRecord;
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
            [['product_id', 'quantity'], 'required'],
            [['quantity'], 'integer', 'min' => 1],
            
            [['product_id'], 'exist', 'targetClass' => Product::className(), 'targetAttribute' => 'id'],
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
    
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->product_json = $this->product->attributes;
            $this->price = $this->product->price;
            $this->total_price = $this->price * $this->quantity;
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterDelete()
    {
        if ($order = $this->order) {
            if (ArrayHelper::getValue($order->statuses(), "$order->status.save_action") == 'minus') {
                $this->product->updateCounters(['quantity' => $this->quantity]);
            }
        }
        
        return parent::afterDelete();
    }
}
