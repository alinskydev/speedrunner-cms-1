<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class ProductVariation extends ActiveRecord
{
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
            [['images'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
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
            'images' => Yii::t('app', 'Images'),
        ];
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
        if ($images = UploadedFile::getInstances($this, 'images')) {
            $this->images = $images;
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        //        IMAGES
        
        $old_images = ArrayHelper::getValue($this->oldAttributes, 'images', []);
        
        if ($images = UploadedFile::getInstances($this, 'images')) {
            foreach ($images as $img) {
                $images_arr[] = Yii::$app->sr->image->save($img);
            }
            
            $this->images = array_merge($old_images, $images_arr);
        } else {
            $this->images = $old_images;
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterDelete()
    {
        foreach ($this->images as $img) {
            Yii::$app->sr->file->delete($img);
        }
        
        return parent::afterDelete();
    }
}
