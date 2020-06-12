<?php

namespace backend\modules\Zzz\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use backend\modules\Zzz\modelsTranslation\ZzzCategoryTranslation;


class ZzzCategory extends ActiveRecord
{
    public $translation_table = 'ZzzCategoryTranslation';
    public $translation_attrs = [
        'name',
        'description',
    ];
    
    public $name;
    public $description;
    
    public static function tableName()
    {
        return 'ZzzCategory';
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
            [['url'], 'unique'],
            [['name', 'url', 'image'], 'string', 'max' => 100],
            [['description'], 'string'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
    
    public function getTranslation()
    {
        return $this->hasOne(ZzzCategoryTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    public function getZzzs()
    {
        return $this->hasMany(Zzz::className(), ['category_id' => 'id']);
    }
}
