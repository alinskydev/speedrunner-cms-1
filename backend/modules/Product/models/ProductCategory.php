<?php

namespace backend\modules\Product\models;

use Yii;
use common\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class ProductCategory extends ActiveRecord
{
    public $parent_id;
    public $specifications_tmp;
    
    public static function tableName()
    {
        return 'ProductCategory';
    }
    
    public function behaviors()
    {
        return [
            'tree' => [
                'class' => \creocoder\nestedsets\NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
            ],
            'htmlTree' => [
                'class' => \wokster\treebehavior\NestedSetsTreeBehavior::className(),
                'labelAttribute' => 'name',
                'isAttributeTranslatable' => true,
            ],
            'sluggable' => [
                'class' => \yii\behaviors\SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => true,
            ],
            'translation' => [
                'class' => \common\behaviors\TranslationBehavior::className(),
                'attributes' => ['name', 'description'],
            ],
            'seo_meta' => [
                'class' => \common\behaviors\SeoMetaBehavior::className(),
            ],
            'relations_many_many' => [
                'class' => \common\behaviors\RelationBehavior::className(),
                'type' => 'manyMany',
                'attributes' => [
                    'specifications_tmp' => [
                        'model' => new ProductCategorySpecificationRef(),
                        'relation' => 'specifications',
                        'attributes' => [
                            'main' => 'category_id',
                            'relational' => 'specification_id',
                        ],
                    ],
                ],
            ],
        ];
    }
    
    public function transactions()
    {
        return [
            static::SCENARIO_DEFAULT => static::OP_ALL,
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'required', 'when' => fn ($model) => $model->isNewRecord],
            [['name', 'slug', 'image'], 'string', 'max' => 100],
            [['description'], 'string'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            
            [['parent_id'], 'exist', 'targetClass' => static::className(), 'targetAttribute' => 'id'],
            [['specifications_tmp'], 'each', 'rule' => ['exist', 'targetClass' => ProductSpecification::className(), 'targetAttribute' => 'id']],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'tree' => Yii::t('app', 'Tree'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'depth' => Yii::t('app', 'Depth'),
            'expanded' => Yii::t('app', 'Expanded'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'image' => Yii::t('app', 'Image'),
            'description' => Yii::t('app', 'Description'),
            'parent_id' => Yii::t('app', 'Parent'),
            'specifications_tmp' => Yii::t('app', 'Specifications'),
        ];
    }
    
    public function url()
    {
        $parents = $this->parents()->orderBy('lft')->andWhere(['>', 'depth', 0])->select(['slug'])->asArray()->all();
        $result = implode('/', ArrayHelper::getColumn($parents, 'slug'));
        
        return $result ? "$result/$this->slug" : $this->slug;
    }
    
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])
            ->viaTable('ProductCategoryRef', ['category_id' => 'id']);
    }
    
    public function getSpecifications()
    {
        return $this->hasMany(ProductSpecification::className(), ['id' => 'specification_id'])
            ->viaTable('ProductCategorySpecificationRef', ['category_id' => 'id']);
    }
    
    public static function find()
    {
        return new \common\query\NestedSetsQuery(get_called_class());
    }
}
