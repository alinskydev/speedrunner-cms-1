<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class ProductVariation extends ActiveRecord
{
    public $images_tmp;
    
    public static function tableName()
    {
        return 'ProductVariation';
    }
    
    public function rules()
    {
        return [
            [['attribute_id', 'option_id'], 'required'],
            [['attribute_id'], 'exist', 'targetClass' => ProductAttribute::className(), 'targetAttribute' => 'id'],
            [['option_id'], 'exist', 'targetClass' => ProductAttributeOption::className(), 'targetAttribute' => 'id'],
            [['price'], 'number'],
            [['sku'], 'string', 'max' => 100],
            [['images_tmp'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'attribute_id' => Yii::t('app', 'Attribute ID'),
            'option_id' => Yii::t('app', 'Option ID'),
            'price' => Yii::t('app', 'Price'),
            'sku' => Yii::t('app', 'Sku'),
            'images_tmp' => Yii::t('app', 'Images'),
        ];
    }
    
    public function getImages()
    {
        return $this->hasMany(ProductVariationImage::className(), ['item_id' => 'id'])->orderBy('sort');
    }
    
    public function getAttr()
    {
        return $this->hasOne(ProductAttribute::className(), ['id' => 'attribute_id']);
    }
    
    public function getOption()
    {
        return $this->hasOne(ProductAttributeOption::className(), ['id' => 'option_id']);
    }
    
    public function beforeValidate()
    {
        if ($images_tmp = UploadedFile::getInstances($this, 'images_tmp')) {
            $this->images_tmp = $images_tmp;
        }
        
        return parent::beforeValidate();
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //      IMAGES
        
        if ($images_tmp = UploadedFile::getInstances($this, 'images_tmp')) {
            Yii::$app->sr->image->save($images_tmp, new ProductVariationImage(['item_id' => $this->id]));
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
