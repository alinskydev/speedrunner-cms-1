<?php

namespace speedrunner\validators;

use Yii;
use yii\helpers\ArrayHelper;

use yii\validators\Validator;


class EitherValidator extends Validator
{
    public $enableClientValidation = false;
    public $skipOnEmpty = false;
    
    public $either_attributes;
    
    public function validateAttribute($model, $attribute)
    {
        $message_params = array_map(function($value) use ($model) {
            return implode(' & ', array_map(fn($val) => $model->getAttributeLabel($val), $value));
        }, array_merge([$this->attributes], [$this->either_attributes]));
        
        $message = $this->message ?? Yii::t('app', 'One of these attributes is required: {value}', [
            'value' => implode(' / ', $message_params),
        ]);
        
        if (!$model->{$attribute}) {
            foreach ($this->either_attributes as $a) {
                if (!$model->{$a}) {
                    return $this->addError($model, $attribute, $message);
                }
            }
        }
    }
}
