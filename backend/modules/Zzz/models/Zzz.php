<?php

namespace backend\modules\Zzz\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\behaviors\SluggableBehavior;


class Zzz extends ActiveRecord
{
    public $translation_attrs = [
        'name',
        'short_description',
        'full_description',
    ];
    
    public static function tableName()
    {
        return 'Zzz';
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
            [['name', 'url', 'image'], 'string', 'max' => 100],
            [['short_description'], 'string', 'max' => 255],
            [['full_description'], 'string'],
            [['url'], 'unique'],
            [['url'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['category_id'], 'exist', 'targetClass' => ZzzCategory::className(), 'targetAttribute' => 'id'],
            [['images'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
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
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
    
    public function getCategory()
    {
        return $this->hasOne(ZzzCategory::className(), ['id' => 'category_id']);
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
    
    public function afterDelete()
    {
        foreach ($this->images as $img) {
            Yii::$app->sr->file->delete($img);
        }
        
        return parent::afterDelete();
    }
}
