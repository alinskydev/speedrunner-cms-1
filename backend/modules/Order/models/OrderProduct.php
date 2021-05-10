<?php

namespace backend\modules\Order\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\Product;
use backend\modules\Product\models\ProductVariation;


class OrderProduct extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%order_product}}';
    }
    
    public function rules()
    {
        return [
            [['product_id', 'quantity'], 'required'],
            [['variation_id'], 'required', 'when' => fn ($model) => $model->product->variations],
            
            [['quantity'], 'integer', 'min' => 1],
            
            [['product_id'], 'exist', 'targetClass' => Product::className(), 'targetAttribute' => 'id'],
            [['variation_id'], 'exist', 'targetClass' => ProductVariation::className(), 'targetAttribute' => 'id', 'filter' => ['product_id' => $this->product_id]],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'order_id' => Yii::t('app', 'Order'),
            'product_id' => Yii::t('app', 'Product'),
            'variation_id' => Yii::t('app', 'Variation'),
            'product_json' => Yii::t('app', 'Product'),
            'image' => Yii::t('app', 'Image'),
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
    
    public function getVariation()
    {
        return $this->hasOne(ProductVariation::className(), ['id' => 'variation_id']);
    }
    
    public function beforeSave($insert)
    {
        //        Setting attributes if product has been changed
        
        if ($this->oldAttributes != $this->attributes && $product = $this->product) {
            $product_json = $product->attributes;
            $product_json['mainCategory'] = $product->mainCategory->attributes;
            $product_json['brand'] = $product->brand->attributes;
            
            if ($variation = ProductVariation::findOne($this->variation_id)) {
                $product->service->assignVariationAttributes($variation);
                $product_json['variation'] = $variation->attributes;
            }
            
            $this->product_json = $product_json;
            
            if (!$this->image && $product_image = ArrayHelper::getValue($product, 'images.0')) {
                $this->image = Yii::$app->services->file->duplicate($product_image, 'uploaded');
            }
            
            $this->price = $product->price;
            $this->discount = $product->discount;
            $this->total_price = $product->service->realPrice() * $this->quantity;
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterDelete()
    {
        Yii::$app->services->file->delete($this->image);
        
        if ($order = $this->order) {
            if (ArrayHelper::getValue($order->enums->statuses(), "$order->status.products_action") == 'minus') {
                $this->product->updateCounters(['quantity' => $this->quantity]);
            }
        }
        
        return parent::afterDelete();
    }
}
