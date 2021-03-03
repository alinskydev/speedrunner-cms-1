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
            if (!is_string($v) || !array_key_exists($key, $this->enums->types())) {
                $this->addError($attribute, Yii::t('app', '{attribute} is incorrect', ['attribute' => $this->getAttributeLabel($attribute)]));
            }
        }
    }
    
    public function beforeSave($insert)
    {
        $this->lang = Yii::$app->language;
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->model_class == 'SeoMeta') {
            $this->updateAttributes(['model_id' => $this->id]);
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
