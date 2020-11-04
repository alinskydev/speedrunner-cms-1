<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;


class ProductBrand extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductBrand';
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
                'attributes' => ['name', 'description'],
            ],
            'seo_meta' => [
                'class' => \common\behaviors\SeoMetaBehavior::className(),
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['name', 'slug', 'image'], 'string', 'max' => 100],
            [['slug'], 'unique'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
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
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
}
