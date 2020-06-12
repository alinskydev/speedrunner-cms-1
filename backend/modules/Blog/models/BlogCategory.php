<?php

namespace backend\modules\Blog\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use backend\modules\Blog\modelsTranslation\BlogCategoryTranslation;


class BlogCategory extends ActiveRecord
{
    public $translation_table = 'BlogCategoryTranslation';
    public $translation_attrs = [
        'name',
        'description',
    ];
    
    public $name;
    public $description;
    
    public $seo_meta = [];
    
    public static function tableName()
    {
        return 'BlogCategory';
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
            [['name', 'url', 'image'], 'string', 'max' => 100],
            [['url'], 'unique'],
            [['url'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['description'], 'string'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
    
    public function getTranslation()
    {
        return $this->hasOne(BlogCategoryTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    public function getBlogs()
    {
        return $this->hasMany(Blog::className(), ['category_id' => 'id']);
    }
}
