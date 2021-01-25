<?php

namespace backend\modules\Product\models;

use Yii;
use common\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class Product extends ActiveRecord
{
    public $categories_tmp;
    public $options_tmp;
    public $related_tmp;
    public $variations_tmp;
    
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
            'translation' => [
                'class' => \common\behaviors\TranslationBehavior::className(),
                'attributes' => ['name', 'short_description', 'full_description'],
            ],
            'files' => [
                'class' => \common\behaviors\FilesBehavior::className(),
                'attributes' => ['images'],
            ],
            'seo_meta' => [
                'class' => \common\behaviors\SeoMetaBehavior::className(),
            ],
            'relations_one_many' => [
                'class' => \common\behaviors\RelationBehavior::className(),
                'type' => 'oneMany',
                'attributes' => [
                    'variations_tmp' => [
                        'model' => new ProductVariation(),
                        'relation' => 'variations',
                        'attributes' => [
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
                    'categories_tmp' => [
                        'model' => new ProductCategoryRef(),
                        'relation' => 'categories',
                        'attributes' => [
                            'main' => 'product_id',
                            'relational' => 'category_id',
                        ],
                    ],
                    'options_tmp' => [
                        'model' => new ProductOptionRef(),
                        'relation' => 'options',
                        'attributes' => [
                            'main' => 'product_id',
                            'relational' => 'option_id',
                        ],
                    ],
                    'related_tmp' => [
                        'model' => new ProductRelatedRef(),
                        'relation' => 'related',
                        'attributes' => [
                            'main' => 'product_id',
                            'relational' => 'related_id',
                        ],
                    ],
                ],
            ],
            'log_actions' => [
                'class' => \common\behaviors\LogActionBehavior::className(),
                'relations_one_many' => [
                    'variations_tmp' => [
                        'relation' => 'variations',
                        'attributes' => ['price', 'quantity', 'sku'],
                    ],
                ],
                'relations_many_many' => [
                    'categories_tmp' => [
                        'relation' => 'categories',
                        'attribute' => 'name',
                    ],
                    'options_tmp' => [
                        'relation' => 'options',
                        'attribute' => 'name',
                    ],
                    'related_tmp' => [
                        'relation' => 'related',
                        'attribute' => 'name',
                    ],
                ],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name', 'main_category_id', 'price'], 'required'],
            [['price', 'quantity'], 'integer', 'min' => 0],
            [['discount'], 'integer', 'min' => 0, 'max' => 100],
            [['name', 'slug', 'sku'], 'string', 'max' => 100],
            [['short_description'], 'string', 'max' => 255],
            [['full_description'], 'string'],
            [['slug'], 'unique'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['images'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
            [['variations_tmp'], 'safe'],
            
            [['brand_id'], 'exist', 'targetClass' => ProductBrand::className(), 'targetAttribute' => 'id'],
            [['main_category_id'], 'exist', 'targetClass' => ProductCategory::className(), 'targetAttribute' => 'id'],
            
            [['categories_tmp'], 'each', 'rule' => ['exist', 'targetClass' => ProductCategory::className(), 'targetAttribute' => 'id']],
            [['options_tmp'], 'each', 'rule' => ['exist', 'targetClass' => ProductSpecificationOption::className(), 'targetAttribute' => 'id']],
            [['related_tmp'], 'each', 'rule' => ['exist', 'targetClass' => Product::className(), 'targetAttribute' => 'id', 'filter' => function ($query) {
                $query->andFilterWhere(['!=', 'id', $this->id]);
            }]],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'short_description' => Yii::t('app', 'Short Description'),
            'full_description' => Yii::t('app', 'Full Description'),
            'images' => Yii::t('app', 'Images'),
            'brand_id' => Yii::t('app', 'Brand'),
            'main_category_id' => Yii::t('app', 'Main category'),
            'price' => Yii::t('app', 'Price'),
            'discount' => Yii::t('app', 'Discount'),
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
    
    public function realPrice()
    {
        return round($this->price * (1 - $this->discount / 100));
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
        return $this->hasMany(static::className(), ['id' => 'related_id'])
            ->viaTable('ProductRelatedRef', ['product_id' => 'id']);
    }
    
    public function getVariations()
    {
        return $this->hasMany(ProductVariation::className(), ['product_id' => 'id'])->orderBy('sort');
    }
}
