<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use backend\modules\Product\modelsTranslation\ProductAttributeOptionTranslation;


class ProductAttributeOption extends ActiveRecord
{
    public $translation_table = 'ProductAttributeOptionTranslation';
    public $translation_attrs = [
        'value',
    ];
    
    public $value;
    
    public static function tableName()
    {
        return 'ProductAttributeOption';
    }
    
    public function rules()
    {
        return [
            [['value', 'sort'], 'required'],
            [['value'], 'string', 'max' => 100],
            [['sort'], 'integer'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'sort' => Yii::t('app', 'Sort'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
    
    public function getTranslation()
    {
        return $this->hasOne(ProductAttributeOptionTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    public function getAttr()
    {
        return $this->hasOne(ProductAttribute::className(), ['id' => 'item_id']);
    }
}
