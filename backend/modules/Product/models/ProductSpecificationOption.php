<?php

namespace backend\modules\Product\models;

use Yii;
use speedrunner\db\ActiveRecord;


class ProductSpecificationOption extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%product_specification_option}}';
    }
    
    public function behaviors()
    {
        return [
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
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
            'specification_id' => Yii::t('app', 'Specification'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
