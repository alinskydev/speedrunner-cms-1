<?php

namespace backend\modules\Product\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;


class ProductCategory extends ActiveRecord
{
    public $parent_id;
    public $specifications_tmp;
    
    public static function tableName()
    {
        return '{{%product_category}}';
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
            'seo_meta' => \speedrunner\behaviors\SeoMetaBehavior::className(),
            'sluggable' => \speedrunner\behaviors\SluggableBehavior::className(),
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
                'attributes' => ['name', 'description'],
            ],
            'relations_many_many' => [
                'class' => \speedrunner\behaviors\RelationBehavior::className(),
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
            'tree' => [
                'class' => \creocoder\nestedsets\NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
            ],
            'htmlTree' => [
                'class' => \wokster\treebehavior\NestedSetsTreeBehavior::className(),
                'labelAttribute' => 'name',
                'isAttributeTranslatable' => true,
            ],
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
            
            [['parent_id'], 'exist', 'targetClass' => self::className(), 'targetAttribute' => 'id'],
            [['specifications_tmp'], 'exist', 'targetClass' => ProductSpecification::className(), 'targetAttribute' => 'id', 'allowArray' => true],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
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
        $parents = $this->parents()->withoutRoots()->orderBy('lft')->select(['slug'])->asArray()->all();
        $result = implode('/', ArrayHelper::getColumn($parents, 'slug'));
        
        return $result ? "$result/$this->slug" : $this->slug;
    }
    
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])
            ->viaTable('product_category_ref', ['category_id' => 'id']);
    }
    
    public function getSpecifications()
    {
        return $this->hasMany(ProductSpecification::className(), ['id' => 'specification_id'])
            ->viaTable('product_category_specification_ref', ['category_id' => 'id']);
    }
    
    public static function find()
    {
        return new \speedrunner\db\NestedSetsQuery(get_called_class());
    }
    
    public function beforeDelete()
    {
        if (Product::find()->andWhere(['main_category_id' => $this->id])->exists()) {
            Yii::$app->session->addFlash('warning', Yii::t('app', 'You cannot delete record which contains any products'));
            return false;
        }
        
        return parent::beforeDelete();
    }
}
