<?php

namespace backend\modules\Blog\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;


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
            'sluggable' => [
                'class' => \yii\behaviors\SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => true,
            ],
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
                'attributes' => ['name', 'short_description', 'full_description'],
            ],
            'files' => [
                'class' => \speedrunner\behaviors\FileBehavior::className(),
                'attributes' => ['images'],
                'multiple' => true,
            ],
            'seo_meta' => [
                'class' => \speedrunner\behaviors\SeoMetaBehavior::className(),
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name', 'image'], 'required'],
            [['name', 'slug', 'image'], 'string', 'max' => 100],
            [['short_description'], 'string', 'max' => 1000],
            [['full_description'], 'string'],
            [['slug'], 'unique'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['published_at'], 'date', 'format' => 'php: d.m.Y H:i'],
            [['images'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
            [['tags_tmp'], 'safe'],
            
            [['category_id'], 'exist', 'targetClass' => BlogCategory::className(), 'targetAttribute' => 'id'],
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
            ->viaTable('blog_tag_ref', ['blog_id' => 'id'], function ($query) {
                $query->onCondition(['lang' => Yii::$app->language]);
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
                $tag_mdl = BlogTag::findOne($value);
                
                if (!$tag_mdl) {
                    $tag_mdl = new BlogTag();
                    $tag_mdl->name = $value;
                    $tag_mdl->save();
                }
                
                if (!in_array($value, $tags)) {
                    $relation_mdl = new BlogTagRef();
                    $relation_mdl->blog_id = $this->id;
                    $relation_mdl->tag_id = $tag_mdl->id;
                    $relation_mdl->lang = Yii::$app->language;
                    $relation_mdl->save();
                }
                
                ArrayHelper::remove($tags, $value);
            }
        }
        
        BlogTagRef::deleteAll(['blog_id' => $this->id, 'tag_id' => $tags, 'lang' => Yii::$app->language]);
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
