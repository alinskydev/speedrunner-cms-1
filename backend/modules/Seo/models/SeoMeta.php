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
            $this->addError($attribute, Yii::t('app', '{attribute} is incorrect', ['attribute' => $this->getAttributeLabel($attribute)]));
        }
        
        foreach ((array)$this->value as $key => $v) {
            if (!array_key_exists($key, $this->enums->types()) || !is_string($v)) {
                $this->addError($attribute, Yii::t('app', '{attribute} is incorrect', ['attribute' => $this->getAttributeLabel($attribute)]));
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
}
