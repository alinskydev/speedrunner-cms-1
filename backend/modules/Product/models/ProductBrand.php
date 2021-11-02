<?php

namespace backend\modules\Product\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use speedrunner\validators\SlugValidator;


class ProductBrand extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%product_brand}}';
    }
    
    public function behaviors()
    {
        return [
            'seo_meta' => \backend\modules\Seo\behaviors\SeoMetaBehavior::className(),
            'sluggable' => [
                'class' => \speedrunner\behaviors\SluggableBehavior::className(),
                'is_translateable' => false,
            ],
        ];
    }
    
    public function prepareRules()
    {
        return [
            'name' => [
                ['required'],
                ['string', 'max' => 100],
            ],
            'slug' => [
                [SlugValidator::className()],
            ],
            'image' => [
                ['required'],
                ['string', 'max' => 100],
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'image' => Yii::t('app', 'Image'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }
    
    public function beforeDelete()
    {
        if (Product::find()->andWhere(['brand_id' => $this->id])->exists()) {
            Yii::$app->session->addFlash('warning', Yii::t('app', 'You cannot delete brand which contains any products'));
            return false;
        }
        
        return parent::beforeDelete();
    }
}
