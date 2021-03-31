<?php

namespace backend\modules\Product\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;


class ProductVariation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%product_variation}}';
    }
    
    public function behaviors()
    {
        return [
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
                'attributes' => ['name'],
            ],
            'files' => [
                'class' => \speedrunner\behaviors\FileBehavior::className(),
                'attributes' => ['images'],
                'multiple' => true,
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name', 'price', 'quantity', 'sku'], 'required'],
            [['name', 'sku'], 'string', 'max' => 100],
            [['price', 'quantity'], 'integer', 'min' => 0],
            [['sku'], 'unique'],
            [['discount'], 'integer', 'min' => 0, 'max' => 100],
            [['discount'], 'default', 'value' => 0],
            [['images'], 'each', 'rule' => ['file', 'extensions' => Yii::$app->params['formats']['image'], 'maxSize' => 1024 * 1024]],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'product_id' => Yii::t('app', 'Product'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'discount' => Yii::t('app', 'Discount'),
            'quantity' => Yii::t('app', 'Quantity'),
            'sku' => Yii::t('app', 'SKU'),
            'images' => Yii::t('app', 'Images'),
        ];
    }
    
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
