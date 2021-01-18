<?php

namespace backend\modules\Blog\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class Blog extends ActiveRecord
{
    use \api\modules\v1\models\Blog;
    
    public $tags_tmp;
    
    public static function tableName()
    {
        return 'Blog';
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
                'attributes' => ['name', 'short_description', 'full_description'],
            ],
            'files' => [
                'class' => \common\behaviors\FilesBehavior::className(),
                'attributes' => ['images'],
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
            [['short_description'], 'string', 'max' => 255],
            [['full_description'], 'string'],
            [['category_id'], 'integer'],
            [['name', 'slug', 'image'], 'string', 'max' => 100],
            [['slug'], 'unique'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['published'], 'date', 'format' => 'php: d.m.Y H:i'],
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
            'short_description' => Yii::t('app', 'Short Description'),
            'full_description' => Yii::t('app', 'Full Description'),
            'images' => Yii::t('app', 'Images'),
            'published' => Yii::t('app', 'Published'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
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
            ->viaTable('BlogTagRef', ['blog_id' => 'id'], function ($query) {
                $query->onCondition(['lang' => Yii::$app->language]);
            });
    }
    
    public function getTagsColumn()
    {
        return implode(', ', ArrayHelper::getColumn($this->tags, 'name'));
    }
    
    public function getComments()
    {
        return $this->hasMany(BlogComment::className(), ['blog_id' => 'id']);
    }
    
    public function getRates()
    {
        return $this->hasMany(BlogRate::className(), ['blog_id' => 'id']);
    }
    
    public function beforeSave($insert)
    {
        $this->published = $this->published ?: date('Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        TAGS
        
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
