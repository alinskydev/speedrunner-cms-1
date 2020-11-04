<?php

namespace backend\modules\Zzz\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class ZzzCategory extends ActiveRecord
{
    public static function tableName()
    {
        return 'ZzzCategory';
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
                'attributes' => ['name', 'description'],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'slug', 'image'], 'string', 'max' => 100],
            [['slug'], 'unique'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['description'], 'string'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'image' => Yii::t('app', 'Image'),
            'description' => Yii::t('app', 'Description'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
    
    public function getZzzs()
    {
        return $this->hasMany(Zzz::className(), ['category_id' => 'id']);
    }
}
