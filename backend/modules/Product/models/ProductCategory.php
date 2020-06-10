<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
use creocoder\nestedsets\NestedSetsBehavior;
use wokster\treebehavior\NestedSetsTreeBehavior;

use backend\modules\Product\modelsTranslation\ProductCategoryTranslation;


class ProductCategory extends ActiveRecord
{
    public $translation_table = 'ProductCategoryTranslation';
    public $translation_attrs = [
        'name',
        'description',
    ];
    
    public $name;
    public $description;
    
    public $parent_id;
    public $attrs_tmp;
    
    public $seo_meta = [];
    
    public static function tableName()
    {
        return 'ProductCategory';
    }
    
    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
            ],
            'htmlTree'=>[
                'class' => NestedSetsTreeBehavior::className(),
            ],
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'url',
            ],
        ];
    }
    
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'url', 'full_url', 'image'], 'string', 'max' => 100],
            [['description'], 'string'],
            [['url'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['full_url'], 'unique', 'message' => Yii::t('app', 'Url must be unique')],
            [['parent_id', 'attrs_tmp'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'full_url' => Yii::t('app', 'Full url'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'tree' => Yii::t('app', 'Tree'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'depth' => Yii::t('app', 'Depth'),
            'expanded' => Yii::t('app', 'Expanded'),
            'parent_id' => Yii::t('app', 'Parent'),
            'attrs_tmp' => Yii::t('app', 'Attributes'),
        ];
    }
    
    static function getItemsList($excepts = [])
    {
        $items = self::find()->orderBy(['lft' => SORT_ASC, 'tree' => SORT_DESC])->with(['translation'])->asArray()->all();
        
        foreach ($items as $item) {
            if (!in_array($item['id'], $excepts)) {
                $result[$item['id']] = str_repeat('- ', $item['depth']) . $item['translation']['name'];
            }
        }
        
        return $result;
    }
    
    public function getTranslation()
    {
        return $this->hasOne(ProductCategoryTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])
            ->viaTable('ProductCategoryRef', ['category_id' => 'id']);
    }
    
    public function getAttrs()
    {
        return $this->hasMany(ProductAttribute::className(), ['id' => 'attribute_id'])
            ->viaTable('ProductCategoryAttributeRef', ['category_id' => 'id']);
    }
    
    public static function find()
    {
        return new ProductCategoryQuery(get_called_class());
    }
    
    public function beforeValidate()
    {
        if ($this->tree == 1) {
            $urls = ArrayHelper::getColumn($this->parents()->orderBy('lft')->all(), 'url');
            $this->full_url = count($urls) > 1 ? ltrim(implode('/', $urls), '/') . "/$this->url" : $this->url;
        }
        
        return parent::beforeValidate();
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        ATTRIBUTES
        
        $attributes = ArrayHelper::map($this->attrs, 'id', 'id');
        
        if ($this->attrs_tmp) {
            foreach ($this->attrs_tmp as $a) {
                $category_attribute = ProductCategoryAttributeRef::find()
                    ->where(['category_id' => $this->id, 'attribute_id' => $a])
                    ->one() ?: new ProductCategoryAttributeRef;
                
                $category_attribute->category_id = $this->id;
                $category_attribute->attribute_id = $a;
                $category_attribute->save();
                
                ArrayHelper::remove($attributes, $a);
            }
        }
        
        ProductCategoryAttributeRef::deleteAll(['category_id' => $this->id, 'attribute_id' => $attributes]);
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        ProductCategoryTranslation::deleteAll(['item_id' => $this->id]);
        ProductCategoryRef::deleteAll(['category_id' => $this->id]);
        ProductCategoryAttributeRef::deleteAll(['category_id' => $this->id]);
        
        return parent::afterDelete();lete();
    }
}
