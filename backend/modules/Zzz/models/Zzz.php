<?php

namespace backend\modules\Zzz\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\behaviors\SluggableBehavior;
use backend\modules\Zzz\modelsTranslation\ZzzTranslation;


class Zzz extends ActiveRecord
{
    public $translation_table = 'ZzzTranslation';
    public $translation_attrs = [
        'name',
        'short_description',
        'full_description',
    ];
    
    public $name;
    public $short_description;
    public $full_description;
    
    public $images_tmp;
    
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
            [['images_tmp'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category'),
            'name' => Yii::t('app', 'Name'),
            'short_description' => Yii::t('app', 'Short Description'),
            'full_description' => Yii::t('app', 'Full Description'),
            'url' => Yii::t('app', 'Url'),
            'image' => Yii::t('app', 'Image'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'images_tmp' => Yii::t('app', 'Images'),
        ];
    }
    
    public function getTranslation()
    {
        return $this->hasOne(ZzzTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    public function getCategory()
    {
        return $this->hasOne(ZzzCategory::className(), ['id' => 'category_id']);
    }
    
    public function getImages()
    {
        return $this->hasMany(ZzzImage::className(), ['item_id' => 'id'])->orderBy('sort');
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
            Yii::$app->sr->image->save($images_tmp, new ZzzImage(['item_id' => $this->id]));
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
