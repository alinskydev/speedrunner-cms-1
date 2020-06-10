<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use backend\modules\Product\modelsTranslation\ProductBrandTranslation;


class ProductBrand extends ActiveRecord
{
    public $translation_table = 'ProductBrandTranslation';
    public $translation_attrs = [
        'name',
        'description',
    ];
    
    public $name;
    public $description;
    
    public $seo_meta = [];
    
    public static function tableName()
    {
        return 'ProductBrand';
    }
    
    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'url',
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['url', 'image'], 'string', 'max' => 100],
            [['url'], 'unique'],
            [['url'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'url' => Yii::t('app', 'Url'),
            'image' => Yii::t('app', 'Image'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
    
    public function getTranslation()
    {
        return $this->hasOne(ProductBrandTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    public function afterDelete()
    {
        ProductBrandTranslation::deleteAll(['item_id' => $this->id]);
        
        return parent::afterDelete();
    }
}
