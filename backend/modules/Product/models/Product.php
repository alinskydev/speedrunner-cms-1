<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class Product extends ActiveRecord
{
    public $translation_attrs = [
        'name',
        'short_description',
        'full_description',
    ];
    
    public $categories_tmp = '[]';
    public $options_tmp = [];
    public $related_tmp;
    public $variations_tmp;
    
    public $seo_meta = [];
    
    public static function tableName()
    {
        return 'Product';
    }
    
    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => \yii\behaviors\SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => true,
            ],
            'files' => [
                'class' => \common\behaviors\FilesBehavior::className(),
                'attributes' => ['images'],
            ],
            'relations_one_many' => [
                'class' => \common\behaviors\RelationBehavior::className(),
                'type' => 'oneMany',
                'attributes' => [
                    [
                        'model' => new ProductVariation,
                        'relation' => 'variations',
                        'attribute' => 'variations_tmp',
                        'properties' => [
                            'main' => 'product_id',
                            'relational' => ['specification_id', 'option_id'],
                        ],
                    ],
                ],
            ],
            'relations_many_many' => [
                'class' => \common\behaviors\RelationBehavior::className(),
                'type' => 'manyMany',
                'attributes' => [
                    [
                        'model' => new ProductOptionRef,
                        'relation' => 'options',
                        'attribute' => 'options_tmp',
                        'properties' => [
                            'main' => 'product_id',
                            'relational' => 'option_id',
                        ],
                    ],
                    [
                        'model' => new ProductRelatedRef,
                        'relation' => 'related',
                        'attribute' => 'related_tmp',
                        'properties' => [
                            'main' => 'product_id',
                            'relational' => 'related_id',
                        ],
                    ],
                ],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name', 'main_category_id'], 'required'],
            [['price', 'sale', 'quantity'], 'integer', 'min' => 0],
            [['sale'], 'compare', 'compareAttribute' => 'price', 'operator' => '<='],
            [['name', 'slug', 'sku'], 'string', 'max' => 100],
            [['short_description'], 'string', 'max' => 255],
            [['full_description'], 'string'],
            [['slug'], 'unique'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['images'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
            [['categories_tmp', 'variations_tmp'], 'safe'],
            
            [['brand_id'], 'exist', 'targetClass' => ProductBrand::className(), 'targetAttribute' => 'id'],
            [['main_category_id'], 'exist', 'targetClass' => ProductCategory::className(), 'targetAttribute' => 'id'],
            [['options_tmp'], 'each', 'rule' => ['exist', 'targetClass' => ProductSpecificationOption::className(), 'targetAttribute' => 'id']],
            [['related_tmp'], 'each', 'rule' => ['exist', 'targetClass' => Product::className(), 'targetAttribute' => 'id', 'filter' => function ($query) {
                $query->andWhere(['!=', 'id', $this->id]);
            }]],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'short_description' => Yii::t('app', 'Short Description'),
            'full_description' => Yii::t('app', 'Full Description'),
            'images' => Yii::t('app', 'Images'),
            'brand_id' => Yii::t('app', 'Brand'),
            'main_category_id' => Yii::t('app', 'Main category'),
            'price' => Yii::t('app', 'Price'),
            'sale' => Yii::t('app', 'Sale'),
            'quantity' => Yii::t('app', 'Quantity'),
            'sku' => Yii::t('app', 'SKU'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'categories_tmp' => Yii::t('app', 'Categories'),
            'options_tmp' => Yii::t('app', 'Options'),
            'related_tmp' => Yii::t('app', 'Related'),
            'variations_tmp' => Yii::t('app', 'Variations'),
        ];
    }
    
    public function getBrand()
    {
        return $this->hasOne(ProductBrand::className(), ['id' => 'brand_id']);
    }
    
    public function getMainCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'main_category_id']);
    }
    
    public function getCategories()
    {
        return $this->hasMany(ProductCategory::className(), ['id' => 'category_id'])
            ->viaTable('ProductCategoryRef', ['product_id' => 'id']);
    }
    
    public function getOptions()
    {
        return $this->hasMany(ProductSpecificationOption::className(), ['id' => 'option_id'])
            ->viaTable('ProductOptionRef', ['product_id' => 'id']);
    }
    
    public function getRelated()
    {
        return $this->hasMany(Product::className(), ['id' => 'related_id'])
            ->viaTable('ProductRelatedRef', ['product_id' => 'id']);
    }
    
    public function getVariations()
    {
        return $this->hasMany(ProductVariation::className(), ['product_id' => 'id'])->orderBy('sort');
    }
    
    public function getComments()
    {
        return $this->hasMany(ProductComment::className(), ['product_id' => 'id']);
    }
    
    public function getRates()
    {
        return $this->hasMany(ProductRate::className(), ['product_id' => 'id']);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        CATEGORIES
        
        $categories = ArrayHelper::map($this->categories, 'id', 'id');
        $categories_tmp = json_decode($this->categories_tmp, true);
        
        if ($categories_tmp) {
            foreach ($categories_tmp as $value) {
                if (!in_array($value, $categories)) {
                    $relation_mdl = new ProductCategoryRef;
                    $relation_mdl->product_id = $this->id;
                    $relation_mdl->category_id = $value;
                    $relation_mdl->save();
                }
                
                ArrayHelper::remove($categories, $value);
            }
        }
        
        ProductCategoryRef::deleteAll(['category_id' => $categories, 'product_id' => $this->id]);
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
