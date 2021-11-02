<?php

namespace backend\modules\Seo\models;

use Yii;
use speedrunner\db\ActiveRecord;


class SeoMeta extends ActiveRecord
{
    public $service = false;
    
    public static function tableName()
    {
        return '{{%seo_meta}}';
    }
    
    public function prepareRules()
    {
        return [
            'value' => [
                ['required'],
                ['valueValidation'],
            ],
        ];
    }
    
    public function valueValidation($attribute, $params, $validator)
    {
        $value = $this->value;
        
        if (!is_array($value)) {
            return $this->addError($attribute, Yii::t('app', '{attribute} is incorrect', ['attribute' => $this->getAttributeLabel($attribute)]));
        }
        
        array_walk_recursive($value, function($value, $key) use ($attribute) {
            if (!is_string($value) || !array_key_exists($key, $this->enums->types())) {
                return $this->addError($attribute, Yii::t('app', '{attribute} is incorrect', ['attribute' => $this->getAttributeLabel($attribute)]));
            }
        });
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->model_class == 'SeoMeta') {
            $this->updateAttributes(['model_id' => $this->id]);
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
