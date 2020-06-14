<?php

namespace backend\modules\Blog\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\behaviors\SluggableBehavior;


class Blog extends ActiveRecord
{
    public $translation_attrs = [
        'name',
        'short_description',
        'full_description',
    ];
    
    public $tags_tmp;
    public $images_tmp;
    
    public $seo_meta = [];
    
    public static function tableName()
    {
        return 'Blog';
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
            [['name'], 'required'],
            [['short_description'], 'string', 'max' => 255],
            [['full_description'], 'string'],
            [['category_id'], 'integer'],
            [['name', 'url', 'image'], 'string', 'max' => 100],
            [['url'], 'unique'],
            [['url'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['published'], 'date', 'format' => 'php: d.m.Y H:i'],
            [['category_id'], 'exist', 'targetClass' => BlogCategory::className(), 'targetAttribute' => 'id'],
            [['images_tmp'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
            [['tags_tmp'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'category_id' => Yii::t('app', 'Category'),
            'image' => Yii::t('app', 'Image'),
            'published' => Yii::t('app', 'Published'),
            'short_description' => Yii::t('app', 'Short Description'),
            'full_description' => Yii::t('app', 'Full Description'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'tags_tmp' => Yii::t('app', 'Tags'),
            'images_tmp' => Yii::t('app', 'Images'),
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
                $query->andWhere(['lang' => Yii::$app->language]);
            });
    }
    
    public function getTagsColumn()
    {
        return implode(', ', ArrayHelper::map($this->tags, 'id', 'name'));
    }
    
    public function getImages()
    {
        return $this->hasMany(BlogImage::className(), ['item_id' => 'id'])->orderBy('sort');
    }
    
    public function getComments()
    {
        return $this->hasMany(BlogComment::className(), ['blog_id' => 'id']);
    }
    
    public function getRates()
    {
        return $this->hasMany(BlogRate::className(), ['blog_id' => 'id']);
    }
    
    public function beforeValidate()
    {
        if ($images_tmp = UploadedFile::getInstances($this, 'images_tmp')) {
            $this->images_tmp = $images_tmp;
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        $this->published = $this->published ?: date('Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        IMAGES
        
        if ($images_tmp = UploadedFile::getInstances($this, 'images_tmp')) {
            Yii::$app->sr->image->save($images_tmp, new BlogImage(['item_id' => $this->id]));
        }
        
        //        TAGS
        
        $tags = ArrayHelper::map($this->tags, 'id', 'id');
        
        if ($this->tags_tmp) {
            foreach ($this->tags_tmp as $t) {
                $tag_mdl = BlogTag::findOne($t);
                
                if (!$tag_mdl) {
                    $tag_mdl = new BlogTag;
                    $tag_mdl->name = $t;
                    $tag_mdl->save();
                }
                
                if (!in_array($t, $tags)) {
                    $blog_tag_mdl = new BlogTagRef;
                    $blog_tag_mdl->blog_id = $this->id;
                    $blog_tag_mdl->tag_id = $tag_mdl->id;
                    $blog_tag_mdl->lang = Yii::$app->language;
                    $blog_tag_mdl->save();
                }
                
                ArrayHelper::remove($tags, $t);
            }
        }
        
        BlogTagRef::deleteAll(['blog_id' => $this->id, 'tag_id' => $tags, 'lang' => Yii::$app->language]);
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
