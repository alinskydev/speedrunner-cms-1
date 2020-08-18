<?php

namespace backend\modules\Seo\models;

use Yii;
use common\components\framework\ActiveRecord;


class SeoMeta extends ActiveRecord
{
    public static function tableName()
    {
        return 'SeoMeta';
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_class' => Yii::t('app', 'Model class'),
            'model_id' => Yii::t('app', 'Model ID'),
            'lang' => Yii::t('app', 'Lang'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
    
    static function types()
    {
        return [
            'title' => [
                'label' => 'Title',
                'type' => 'inputField',
            ],
            'description' => [
                'label' => 'Description',
                'type' => 'textArea',
            ],
            'og:title' => [
                'label' => 'Og:title',
                'type' => 'inputField',
            ],
            'og:description' => [
                'label' => 'Og:description',
                'type' => 'textArea',
            ],
            'og:image' => [
                'label' => 'Og:image',
                'type' => 'ElFinder',
            ]
        ];
    }
}
