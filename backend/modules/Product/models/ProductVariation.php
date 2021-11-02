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
    
    public function prepareRules()
    {
        return [
            'name' => [
                ['each', 'rule' => ['required']],
                ['each', 'rule' => ['string', 'max' => 100]],
            ],
            'price' => [
                ['required'],
                ['integer', 'min' => 0],
            ],
            'discount' => [
                ['integer', 'min' => 0, 'max' => 100],
                ['default', 'value' => 0],
            ],
            'quantity' => [
                ['required'],
                ['integer', 'min' => 0],
            ],
            'sku' => [
                ['required'],
                ['unique'],
                ['string', 'max' => 100],
            ],
            'images' => [
                ['each', 'rule' => ['file', 'extensions' => Yii::$app->params['extensions']['image'], 'maxSize' => 1024 * 1024]],
            ],
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
