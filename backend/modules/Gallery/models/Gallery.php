<?php

namespace backend\modules\Gallery\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\behaviors\SluggableBehavior;


class Gallery extends ActiveRecord
{
    public $images_tmp;
    
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
            [['images_tmp'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'images_tmp' => Yii::t('app', 'Images'),
        ];
    }
    
    public function getImages()
    {
        return $this->hasMany(GalleryImage::className(), ['item_id' => 'id'])->orderBy('sort');
    }
    
    public function beforeValidate()
    {
        if ($images_tmp = UploadedFile::getInstances($this, 'images_tmp')) {
            $this->images_tmp = $images_tmp;
        }
        
        return parent::beforeValidate();
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if ($images_tmp = UploadedFile::getInstances($this, 'images_tmp')) {
            Yii::$app->sr->image->save($images_tmp, new GalleryImage(['item_id' => $this->id]));
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        foreach ($this->images as $img) { $img->delete(); };
        
        return parent::afterDelete();
    }
}
