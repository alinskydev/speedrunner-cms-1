<?php

namespace backend\modules\Product\models;

use Yii;
use common\framework\ActiveRecord;


class ProductSpecificationOption extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductSpecificationOption';
    }
    
    public function behaviors()
    {
        return [
            'translation' => [
                'class' => \common\behaviors\TranslationBehavior::className(),
                'attributes' => ['name'],
            ],
        ];
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
            'id' => Yii::t('app', 'Id'),
            'item_id' => Yii::t('app', 'Specification'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
    
    public function getSpecification()
    {
        return $this->hasOne(ProductSpecification::className(), ['id' => 'item_id']);
    }
}
