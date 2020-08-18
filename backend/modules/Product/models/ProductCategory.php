<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
use creocoder\nestedsets\NestedSetsBehavior;
use wokster\treebehavior\NestedSetsTreeBehavior;
use yii\db\Expression;


class ProductCategory extends ActiveRecord
{
    public $translation_attrs = [
        'name',
        'description',
    ];
    
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
                'immutable' => true,
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
            [['name', 'url', 'image'], 'string', 'max' => 100],
            [['description'], 'string'],
            [['url'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['parent_id'], 'required', 'when' => function ($model) {
                return $model->isNewRecord;
            }],
            [['parent_id'], 'exist', 'targetClass' => self::className(), 'targetAttribute' => 'id'],
            [['attrs_tmp'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tree' => Yii::t('app', 'Tree'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'depth' => Yii::t('app', 'Depth'),
            'expanded' => Yii::t('app', 'Expanded'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'image' => Yii::t('app', 'Image'),
            'description' => Yii::t('app', 'Description'),
            'parent_id' => Yii::t('app', 'Parent'),
            'attrs_tmp' => Yii::t('app', 'Attributes'),
        ];
    }
    
    public function fullUrl()
    {
        $parents = $this->parents()->orderBy('lft')->andWhere(['>', 'depth', 0])->select(['url'])->asArray()->all();
        $result = implode('/', ArrayHelper::getColumn($parents, 'url'));
        
        return $result ? "$result/$this->url" : $this->url;
    }
    
    static function itemsTree($excepts = [])
    {
        $lang = Yii::$app->language;
        
        $result = self::find()
            ->select([
                'id',
                new Expression("CONCAT(REPEAT(('- '), (depth - 1)), name->>'$.$lang') as name")
            ])
            ->where(['not in', 'id', $excepts])
            ->orderBy(['lft' => SORT_ASC, 'tree' => SORT_DESC])
            ->asArray()->all();
        
        return ArrayHelper::map($result, 'id', 'name');
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
}
