<?php

namespace backend\modules\Page\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;

use speedrunner\validators\SlugValidator;
use speedrunner\validators\TranslationValidator;


class Page extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%page}}';
    }
    
    public function behaviors()
    {
        return [
            'seo_meta' => \speedrunner\behaviors\SeoMetaBehavior::className(),
            'sluggable' => \speedrunner\behaviors\SluggableBehavior::className(),
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
                'attributes' => ['name', 'description'],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'each', 'rule' => ['required']],
            [['name'], 'each', 'rule' => ['string', 'max' => 100]],
            [['image'], 'string', 'max' => 100],
            [['description'], 'each', 'rule' => ['string']],
            
            [['slug'], SlugValidator::className()],
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
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }
}
