<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use backend\modules\Product\modelsTranslation\ProductAttributeTranslation;
use backend\modules\Product\modelsTranslation\ProductAttributeOptionTranslation;


class ProductAttribute extends ActiveRecord
{
    public $translation_table = 'ProductAttributeTranslation';
    public $translation_attrs = [
        'name',
    ];
    
    public $name;
    
    public $options_tmp;
    
    public static function tableName()
    {
        return 'ProductAttribute';
    }
    
    public function rules()
    {
        return [
            [['name', 'code', 'type'], 'required'],
            [['name', 'code'], 'string', 'max' => 100],
            [['code'], 'unique'],
            [['code'], 'match', 'pattern' => '/^[a-zA-Z0-9\_-]+$/', 'message' => Yii::t('app', 'Field must contain only alphabet and numerical chars')],
            [['use_filter', 'use_compare', 'use_detail'], 'boolean'],
            [['type'], 'in', 'range' => array_keys($this->types)],
            [['options_tmp'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'type' => Yii::t('app', 'Type'),
            'use_filter' => Yii::t('app', 'Use in filter'),
            'use_compare' => Yii::t('app', 'Use in compare'),
            'use_detail' => Yii::t('app', 'Use in detail page'),
            'options_tmp' => Yii::t('app', 'Options'),
        ];
    }
    
    static function getTypes()
    {
        return [
            'select' => 'Select',
            'checkbox' => 'Checkbox',
        ];
    }
    
    public function getTranslation()
    {
        return $this->hasOne(ProductAttributeTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    public function getOptions()
    {
        return $this->hasMany(ProductAttributeOption::className(), ['item_id' => 'id'])->orderBy('sort');
    }
    
    public function getCats()
    {
        return $this->hasMany(ProductCategory::className(), ['id' => 'category_id'])
            ->viaTable('ProductCategoryAttributeRef', ['attribute_id' => 'id']);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        OPTIONS
        
        $options = ArrayHelper::index($this->options, 'id');
        
        if ($this->options_tmp) {
            $counter = 0;
            
            foreach ($this->options_tmp as $key => $o) {
                $attr_option_mdl = ProductAttributeOption::findOne($key) ?: new ProductAttributeOption;
                $attr_option_mdl->item_id = $this->id;
                $attr_option_mdl->value = ArrayHelper::getValue($o, 'value');
                $attr_option_mdl->sort = $counter;
                $attr_option_mdl->save();
                
                ArrayHelper::remove($options, $key);
                $counter++;
            }
        }
        
        foreach ($options as $o) { $o->delete(); };
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
