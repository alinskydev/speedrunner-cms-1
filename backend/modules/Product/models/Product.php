<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\behaviors\SluggableBehavior;


class Product extends ActiveRecord
{
    public $translation_attrs = [
        'name',
        'short_description',
        'full_description',
    ];
    
    public $cats_tmp = '[]';
    public $options_tmp = [];
    public $related_tmp;
    public $vars_tmp;
    
    public $seo_meta = [];
    
    public function init()
    {
        if (!method_exists($this, 'search')) {
            $this->is_active = 1;
        }
        
        parent::init();
    }
    
    public static function tableName()
    {
        return 'Product';
    }
    
    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'url',
                'immutable' => true,
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name', 'main_category_id'], 'required'],
            [['quantity'], 'integer'],
            [['price', 'sale'], 'number'],
            [['is_active'], 'boolean'],
            [['name', 'url', 'sku'], 'string', 'max' => 100],
            [['short_description'], 'string', 'max' => 255],
            [['full_description'], 'string'],
            [['url'], 'unique'],
            [['url'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['brand_id'], 'exist', 'targetClass' => ProductBrand::className(), 'targetAttribute' => 'id'],
            [['main_category_id'], 'exist', 'targetClass' => ProductCategory::className(), 'targetAttribute' => 'id'],
            [['images'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
            [['related_tmp'], 'each', 'rule' => ['exist', 'targetClass' => ProductCategory::className(), 'targetAttribute' => 'id', 'filter' => function ($query) {
                $query->andWhere(['!=', 'id', $this->id]);
            }]],
            
            [['cats_tmp', 'options_tmp', 'vars_tmp'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'short_description' => Yii::t('app', 'Short Description'),
            'full_description' => Yii::t('app', 'Full Description'),
            'images' => Yii::t('app', 'Images'),
            'brand_id' => Yii::t('app', 'Brand ID'),
            'main_category_id' => Yii::t('app', 'Main category'),
            'price' => Yii::t('app', 'Price'),
            'sale' => Yii::t('app', 'Sale'),
            'quantity' => Yii::t('app', 'Quantity'),
            'sku' => Yii::t('app', 'Sku'),
            'is_active' => Yii::t('app', 'Is Active'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'cats_tmp' => Yii::t('app', 'Categories'),
            'options_tmp' => Yii::t('app', 'Options'),
            'related_tmp' => Yii::t('app', 'Related'),
            'vars_tmp' => Yii::t('app', 'Variations'),
        ];
    }
    
    public function getBrand()
    {
        return $this->hasOne(ProductBrand::className(), ['id' => 'brand_id']);
    }
    
    public function getMainCat()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'main_category_id']);
    }
    
    public function getCats()
    {
        return $this->hasMany(ProductCategory::className(), ['id' => 'category_id'])
            ->viaTable('ProductCategoryRef', ['product_id' => 'id'], function ($query) {
                $query->alias('cats_ref');
            });
    }
    
    public function getOptions()
    {
        return $this->hasMany(ProductAttributeOption::className(), ['id' => 'option_id'])
            ->viaTable('ProductOptionRef', ['product_id' => 'id']);
    }
    
    public function getAttrs()
    {
        return $this->hasMany(ProductAttribute::className(), ['id' => 'attribute_id'])
            ->viaTable('ProductOptionRef', ['product_id' => 'id']);
    }
    
    public function getRelated()
    {
        return $this->hasMany(Product::className(), ['id' => 'related_id'])
            ->viaTable('ProductRelatedRef', ['product_id' => 'id']);
    }
    
    public function getVars()
    {
        return $this->hasMany(ProductVariation::className(), ['item_id' => 'id']);
    }
    
    public function getComments()
    {
        return $this->hasMany(ProductComment::className(), ['product_id' => 'id']);
    }
    
    public function getRates()
    {
        return $this->hasMany(ProductRate::className(), ['product_id' => 'id']);
    }
    
    public function getAttrsUsed()
    {
        $options = self::find()
            ->with(['options.translation', 'options.attr.translation'])
            ->where(['id' => $this->id])
            ->asArray()->one();
        
        foreach ($options['options'] as $o) {
            if (!$result[$o['attr']['translation']['name']]) {
                $result[$o['attr']['translation']['name']] = [];
            }
            array_push($result[$o['attr']['translation']['name']], $o['translation']['name']);
        }
        
        return $result;
    }
    
    public function beforeValidate()
    {
        if ($images = UploadedFile::getInstances($this, 'images')) {
            $this->images = $images;
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        //        IMAGES
        
        $old_images = ArrayHelper::getValue($this->oldAttributes, 'images', []);
        
        if ($images = UploadedFile::getInstances($this, 'images')) {
            foreach ($images as $img) {
                $images_arr[] = Yii::$app->sr->image->save($img);
            }
            
            $this->images = array_merge($old_images, $images_arr);
        } else {
            $this->images = $old_images;
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        CATEGORIES
        
        $cats = ArrayHelper::map($this->cats, 'id', 'id');
        $cats_tmp = json_decode($this->cats_tmp, true);
        
        if ($cats_tmp) {
            foreach ($cats_tmp as $c) {
                $prod_cat = ProductCategoryRef::find()
                    ->where(['product_id' => $this->id, 'category_id' => $c])
                    ->one() ?: new ProductCategoryRef;
                
                $prod_cat->product_id = $this->id;
                $prod_cat->category_id = $c;
                $prod_cat->save();
                
                ArrayHelper::remove($cats, $c);
            }
        }
        
        ProductCategoryRef::deleteAll(['category_id' => $cats, 'product_id' => $this->id]);
        
        //        OPTIONS
        
        $options = ArrayHelper::map($this->options, 'id', 'id');
        
        if ($this->options_tmp) {
            foreach ($this->options_tmp as $key => $opt_tmp) {
                foreach ($opt_tmp as $o) {
                    $option_mdl = ProductOptionRef::find()
                        ->where(['product_id' => $this->id, 'option_id' => $o])
                        ->one() ?: new ProductOptionRef;
                    
                    $option_mdl->product_id = $this->id;
                    $option_mdl->attribute_id = $key;
                    $option_mdl->option_id = $o;
                    $option_mdl->save();
                    
                    ArrayHelper::remove($options, $o);
                }
            }
        }
        
        ProductOptionRef::deleteAll(['option_id' => $options, 'product_id' => $this->id]);
        
        //        RELATED
        
        $related = ArrayHelper::map($this->related, 'id', 'id');
        
        if ($this->related_tmp) {
            foreach ($this->related_tmp as $r) {
                if (!in_array($r, $related)) {
                    $related_mdl = new ProductRelatedRef;
                    $related_mdl->product_id = $this->id;
                    $related_mdl->related_id = $r;
                    $related_mdl->save();
                }
                
                ArrayHelper::remove($related, $r);
            }
        }
        
        ProductRelatedRef::deleteAll(['related_id' => $related, 'product_id' => $this->id]);
        
        //        VARIATIONS
        
        $vars = ArrayHelper::index($this->vars, 'id');
        
        if ($this->vars_tmp) {
            foreach ($this->vars_tmp as $key => $v) {
                $var_mdl = ProductVariation::find()
                    ->where(['item_id' => $this->id, 'attribute_id' => $v['attribute_id'], 'option_id' => $v['option_id']])
                    ->one() ?: new ProductVariation;
                
                $var_mdl->item_id = $this->id;
                $var_mdl->attribute_id = $v['attribute_id'];
                $var_mdl->option_id = $v['option_id'];
                $var_mdl->save();
                
                ArrayHelper::remove($vars, $key);
            }
        }
        
        foreach ($vars as $v) { $v->delete(); };
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        foreach ($this->images as $img) {
            Yii::$app->sr->file->delete($img);
        }
        
        return parent::afterDelete();
    }
}
