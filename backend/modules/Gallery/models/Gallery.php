<?php

namespace backend\modules\Gallery\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class Gallery extends ActiveRecord
{
    public static function tableName()
    {
        return 'Gallery';
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
            'seo_meta' => [
                'class' => \common\behaviors\SeoMetaBehavior::className(),
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 100],
            [['slug'], 'unique'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['images'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'images' => Yii::t('app', 'Images'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
}
