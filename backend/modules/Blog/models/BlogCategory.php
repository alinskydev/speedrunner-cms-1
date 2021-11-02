<?php

namespace backend\modules\Blog\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use speedrunner\validators\SlugValidator;


class BlogCategory extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%blog_category}}';
    }
    
    public function behaviors()
    {
        return [
            'seo_meta' => \backend\modules\Seo\behaviors\SeoMetaBehavior::className(),
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
                'attributes' => ['name', 'description'],
            ],
            'sluggable' => [
                'class' => \speedrunner\behaviors\SluggableBehavior::className(),
                'is_translateable' => true,
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
            'image' => [
                ['string', 'max' => 100],
            ],
            'description' => [
                ['each', 'rule' => ['string']],
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
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }
    
    public function getBlogs()
    {
        return $this->hasMany(Blog::className(), ['category_id' => 'id']);
    }
}
