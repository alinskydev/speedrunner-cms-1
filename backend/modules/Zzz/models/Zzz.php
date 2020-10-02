<?php

namespace backend\modules\Zzz\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class Zzz extends ActiveRecord
{
    public $translation_attributes = [
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
                'class' => \yii\behaviors\SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => true,
            ],
            'files' => [
                'class' => \common\behaviors\FilesBehavior::className(),
                'attributes' => ['images'],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'slug', 'image'], 'string', 'max' => 100],
            [['short_description'], 'string', 'max' => 255],
            [['full_description'], 'string'],
            [['slug'], 'unique'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['images'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
            
            [['category_id'], 'exist', 'targetClass' => ZzzCategory::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
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
}
