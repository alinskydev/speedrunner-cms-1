<?php

namespace backend\modules\Gallery\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\behaviors\SluggableBehavior;


class Gallery extends ActiveRecord
{
    public $seo_meta = [];
    
    public static function tableName()
    {
        return 'Gallery';
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
            [['name', 'url'], 'string', 'max' => 100],
            [['url'], 'unique'],
            [['url'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['images'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'images' => Yii::t('app', 'Images'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
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
