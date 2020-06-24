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
            [['images'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
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
                $query->andWhere(['lang' => Yii::$app->language]);
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
    
    public function beforeValidate()
    {
        if ($images = UploadedFile::getInstances($this, 'images')) {
            $this->images = $images;
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        $this->published = $this->published ?: date('Y-m-d H:i:s');
        
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
    
    public function afterDelete()
    {
        foreach ($this->images as $img) {
            Yii::$app->sr->file->delete($img);
        }
        
        return parent::afterDelete();
    }
}
