<?php

namespace backend\modules\Page\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use backend\modules\Page\modelsTranslation\PageTranslation;


class Page extends ActiveRecord
{
    public $translation_table = 'PageTranslation';
    public $translation_attrs = [
        'name',
        'description',
    ];
    
    public $name;
    public $description;
    
    public $seo_meta = [];
    
    
    public static function tableName()
    {
        return 'Page';
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
            [['description'], 'string'],
            [['name', 'url'], 'string', 'max' => 100],
            [['url'], 'unique'],
            [['url'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'url' => Yii::t('app', 'Url'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
    
    
    public function getTranslation()
    {
        return $this->hasOne(PageTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    
    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        PageTranslation::deleteAll(['item_id' => $this->id]);
        
        return parent::afterDelete();
    }
}
