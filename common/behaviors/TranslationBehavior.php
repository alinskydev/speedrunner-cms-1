<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use common\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;


class TranslationBehavior extends Behavior
{
    public $attributes;
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ];
    }
    
    public function afterFind($event)
    {
        foreach ($this->attributes as $a) {
            $this->owner->{$a} = ArrayHelper::getValue($this->owner->{$a}, Yii::$app->language);
        }
    }
    
    public function beforeSave($event)
    {
        foreach ($this->attributes as $a) {
            if ($json = ArrayHelper::getValue($this->owner->oldAttributes, $a)) {
                $json[Yii::$app->language] = $this->owner->{$a};
            } else {
                $langs = Yii::$app->services->i18n::$languages;
                
                foreach ($langs as $l) {
                    $json[$l['code']] = $this->owner->{$a};
                }
            }
            
            $this->owner->{$a} = $json;
        }
    }
}
