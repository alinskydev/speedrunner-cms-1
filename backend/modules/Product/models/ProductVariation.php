<?php

namespace backend\modules\Product\models;

use Yii;
use common\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class ProductVariation extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductVariation';
    }
    
    public function behaviors()
    {
        return [
            'files' => [
                'class' => \common\behaviors\FilesBehavior::className(),
                'attributes' => ['images'],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['specification_id', 'option_id'], 'required'],
            [['price', 'quantity'], 'integer', 'min' => 0],
            [['sku'], 'string', 'max' => 100],
            [['images'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
            
            [['specification_id'], 'exist', 'targetClass' => ProductSpecification::className(), 'targetAttribute' => 'id'],
            [['option_id'], 'exist', 'targetClass' => ProductSpecificationOption::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'product_id' => Yii::t('app', 'Product'),
            'specification_id' => Yii::t('app', 'Specification'),
            'option_id' => Yii::t('app', 'Option'),
            'price' => Yii::t('app', 'Price'),
            'quantity' => Yii::t('app', 'Quantity'),
            'sku' => Yii::t('app', 'Sku'),
            'images' => Yii::t('app', 'Images'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
    
    public function getSpecification()
    {
        return $this->hasOne(ProductSpecification::className(), ['id' => 'specification_id']);
    }
    
    public function getOption()
    {
        return $this->hasOne(ProductSpecificationOption::className(), ['id' => 'option_id']);
    }
}
