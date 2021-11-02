<?php

namespace speedrunner\behaviors;

use Yii;
use yii\base\Behavior;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

use backend\modules\System\models\SystemLanguage;


class TranslationBehavior extends Behavior
{
    public $attributes;
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }
    
    public function afterFind($event)
    {
        foreach ($this->attributes as $a) {
            $this->owner->translation_attributes[$a] = $this->owner->{$a};
            $this->owner->{$a} = ArrayHelper::getValue($this->owner->{$a}, Yii::$app->language);
        }
    }
    
    public function beforeValidate($event)
    {
        if (!method_exists($this->owner, 'search')) {
            foreach ($this->attributes as $a) {
                foreach (Yii::$app->urlManager->languages as $lang_code => $lang) {
                    $value[$lang_code] = $this->owner->{$a}[$lang_code] ?? null;
                }
                
                $this->owner->{$a} = $value;
            }
        }
    }
}
