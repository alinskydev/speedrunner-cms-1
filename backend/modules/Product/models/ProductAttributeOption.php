<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;


class ProductAttributeOption extends ActiveRecord
{
    public $translation_attrs = [
        'name',
    ];
    
    public static function tableName()
    {
        return 'ProductAttributeOption';
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'name' => Yii::t('app', 'Name'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }
    
    public function getAttr()
    {
        return $this->hasOne(ProductAttribute::className(), ['id' => 'item_id']);
    }
}
