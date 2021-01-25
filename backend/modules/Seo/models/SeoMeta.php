<?php

namespace backend\modules\Seo\models;

use Yii;
use common\framework\ActiveRecord;


class SeoMeta extends ActiveRecord
{
    public static function tableName()
    {
        return 'SeoMeta';
    }
    
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'valueValidation'],
        ];
    }
    
    public function valueValidation($attribute, $params, $validator)
    {
        if (!is_array($this->value)) {
            $this->addError($attribute, Yii::t('app', '{attribute} is incorrect', ['attribute' => $attribute]));
        }
        
        foreach ((array)$this->value as $key => $v) {
            if (!array_key_exists($key, $this->types()) || !is_string($v)) {
                $this->addError($attribute, Yii::t('app', '{attribute} is incorrect', ['attribute' => $attribute]));
            }
        }
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'model_class' => Yii::t('app', 'Model class'),
            'model_id' => Yii::t('app', 'Model id'),
            'lang' => Yii::t('app', 'Language'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
    
    public static function types()
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
