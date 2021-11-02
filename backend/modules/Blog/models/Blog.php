<?php

namespace backend\modules\Blog\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use speedrunner\validators\SlugValidator;


class Blog extends ActiveRecord
{
    public $tags_tmp;
    
    public static function tableName()
    {
        return '{{%blog}}';
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
            'category_id' => [
                ['exist', 'targetClass' => BlogCategory::className(), 'targetAttribute' => 'id'],
            ],
            'image' => [
                ['required'],
                ['string', 'max' => 100],
            ],
            'short_description' => [
                ['each', 'rule' => ['string', 'max' => 1000]],
            ],
            'full_description' => [
                ['each', 'rule' => ['string']],
            ],
            'published_at' => [
                ['date', 'format' => 'php: d.m.Y H:i'],
            ],
            'images' => [
                ['each', 'rule' => ['file', 'extensions' => Yii::$app->params['extensions']['image'], 'maxSize' => 1024 * 1024]],
            ],
            'tags_tmp' => [
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
            'category_id' => Yii::t('app', 'Category'),
            'image' => Yii::t('app', 'Image'),
            'short_description' => Yii::t('app', 'Short description'),
            'full_description' => Yii::t('app', 'Full description'),
            'images' => Yii::t('app', 'Images'),
            'published_at' => Yii::t('app', 'Published at'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            
            'tags_tmp' => Yii::t('app', 'Tags'),
        ];
    }
    
    public function getCategory()
    {
        return $this->hasOne(BlogCategory::className(), ['id' => 'category_id']);
    }
    
    public function getTags()
    {
        return $this->hasMany(BlogTag::className(), ['id' => 'tag_id'])
            ->viaTable('blog_tag_ref', ['blog_id' => 'id'], function($query) {
                $query->onCondition(['language' => Yii::$app->language]);
            });
    }
    
    public function beforeSave($insert)
    {
        $this->published_at = $this->published_at ?: date('Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        Tags
        
        $tags = ArrayHelper::map($this->tags, 'id', 'id');
        
        if ($this->tags_tmp) {
            foreach ($this->tags_tmp as $value) {
                $tag_model = BlogTag::findOne($value);
                
                if (!$tag_model) {
                    $tag_model = new BlogTag();
                    $tag_model->name = $value;
                    $tag_model->save();
                }
                
                if (!in_array($value, $tags)) {
                    $relation_model = new BlogTagRef();
                    $relation_model->blog_id = $this->id;
                    $relation_model->tag_id = $tag_model->id;
                    $relation_model->language = Yii::$app->language;
                    $relation_model->save();
                }
                
                ArrayHelper::remove($tags, $value);
            }
        }
        
        BlogTagRef::deleteAll(['blog_id' => $this->id, 'tag_id' => $tags, 'language' => Yii::$app->language]);
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
