<?php

namespace backend\modules\Product\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use speedrunner\validators\SlugValidator;


class Product extends ActiveRecord
{
    public $categories_tmp;
    public $options_tmp;
    public $variations_tmp;
    
    public static function tableName()
    {
        return '{{%product}}';
    }
    
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'empty' => [],
        ]);
    }
    
    public function behaviors()
    {
        return [
            'seo_meta' => \backend\modules\Seo\behaviors\SeoMetaBehavior::className(),
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
                'attributes' => ['name', 'short_description', 'full_description'],
            ],
            'sluggable' => [
                'class' => \speedrunner\behaviors\SluggableBehavior::className(),
                'is_translateable' => true,
            ],
            'files' => [
                'class' => \speedrunner\behaviors\FileBehavior::className(),
                'attributes' => ['images'],
                'multiple' => true,
            ],
            'relations_one_many' => [
                'class' => \speedrunner\behaviors\RelationBehavior::className(),
                'type' => 'oneMany',
                'attributes' => [
                    'variations_tmp' => [
                        'model' => new ProductVariation(),
                        'relation' => 'variations',
                        'attributes' => [
                            'main' => 'product_id',
                            'relational' => ['name', 'price', 'discount', 'quantity', 'sku'],
                        ],
                    ],
                ],
            ],
            'relations_many_many' => [
                'class' => \speedrunner\behaviors\RelationBehavior::className(),
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
                ],
            ],
            'log_actions' => [
                'class' => \backend\modules\Log\behaviors\LogActionBehavior::className(),
                'relations_one_many' => [
                    'variations_tmp' => [
                        'relation' => 'variations',
                        'attributes' => ['name', 'price', 'discount', 'quantity', 'sku'],
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
                ],
            ],
        ];
    }
    
    public function prepareRules()
    {
        return [
            'name' => [
                ['each', 'rule' => ['required']],
                ['each', 'rule' => ['string', 'max' => 100]],
            ],
            'slug' => [
                [SlugValidator::className()],
            ],
            'short_description' => [
                ['each', 'rule' => ['string', 'max' => 1000]],
            ],
            'full_description' => [
                ['each', 'rule' => ['string']],
            ],
            'images' => [
                ['each', 'rule' => ['file', 'extensions' => Yii::$app->params['extensions']['image'], 'maxSize' => 1024 * 1024]],
            ],
            'brand_id' => [
                ['required'],
                ['exist', 'targetClass' => ProductBrand::className(), 'targetAttribute' => 'id'],
            ],
            'main_category_id' => [
                ['required'],
                ['exist', 'targetClass' => ProductCategory::className(), 'targetAttribute' => 'id'],
            ],
            'price' => [
                ['required', 'enableClientValidation' => false, 'when' => fn($model) => !$model->variations_tmp],
                ['integer', 'min' => 0],
            ],
            'discount' => [
                ['integer', 'min' => 0, 'max' => 100],
                ['default', 'value' => 0],
            ],
            'quantity' => [
                ['required', 'enableClientValidation' => false, 'when' => fn($model) => !$model->variations_tmp],
                ['integer', 'min' => 0],
            ],
            'sku' => [
                ['required', 'enableClientValidation' => false, 'when' => fn($model) => !$model->variations_tmp],
                ['unique'],
                ['string', 'max' => 100],
            ],
            'related_ids' => [
                [
                    'exist',
                    'targetClass' => Product::className(),
                    'targetAttribute' => 'id',
                    'allowArray' => true,
                    'filter' => fn($query) => $query->andWhere(['!=', 'id', $this->id]),
                ],
                ['default', 'value' => []],
            ],
            'categories_tmp' => [
                ['exist', 'targetClass' => ProductCategory::className(), 'targetAttribute' => 'id', 'allowArray' => true],
            ],
            'options_tmp' => [
                ['exist', 'targetClass' => ProductSpecificationOption::className(), 'targetAttribute' => 'id', 'allowArray' => true],
            ],
            'variations_tmp' => [
                ['safe'],
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'short_description' => Yii::t('app', 'Short description'),
            'full_description' => Yii::t('app', 'Full description'),
            'images' => Yii::t('app', 'Images'),
            'brand_id' => Yii::t('app', 'Brand'),
            'main_category_id' => Yii::t('app', 'Main category'),
            'price' => Yii::t('app', 'Price'),
            'discount' => Yii::t('app', 'Discount'),
            'quantity' => Yii::t('app', 'Quantity'),
            'sku' => Yii::t('app', 'SKU'),
            'related_ids' => Yii::t('app', 'Related'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            
            'categories_tmp' => Yii::t('app', 'Categories'),
            'options_tmp' => Yii::t('app', 'Options'),
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
            ->viaTable('product_category_ref', ['product_id' => 'id']);
    }
    
    public function getOptions()
    {
        return $this->hasMany(ProductSpecificationOption::className(), ['id' => 'option_id'])
            ->viaTable('product_option_ref', ['product_id' => 'id']);
    }
    
    public function getVariations()
    {
        return $this->hasMany(ProductVariation::className(), ['product_id' => 'id'])->orderBy('sort');
    }
    
    public function beforeValidate()
    {
        //        Setting values from first variation
        
        if ($this->variations_tmp) {
            $first_variation = reset($this->variations_tmp);
            
            $this->price = ArrayHelper::getValue($first_variation, 'price');
            $this->discount = ArrayHelper::getValue($first_variation, 'discount');
            $this->quantity = ArrayHelper::getValue($first_variation, 'quantity');
            $this->sku = ArrayHelper::getValue($first_variation, 'sku');
        }
        
        return parent::beforeValidate();
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        Saving parent categories
        
        parent::afterSave($insert, $changedAttributes);
        
        $this->refresh();
        
        foreach ($this->categories as $category) {
            if ($parent_categories = $category->parents()->withoutRoots()->asObject()->all()) {
                foreach ($parent_categories as $p_c) {
                    $records[] = [
                        $this->id,
                        $p_c->id,
                    ];
                }
                
                Yii::$app->db->createCommand()->batchInsert('product_category_ref', ['product_id', 'category_id'], $records)->execute();
            }
        }
    }
}
