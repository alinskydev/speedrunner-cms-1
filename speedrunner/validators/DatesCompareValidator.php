<?php

namespace speedrunner\validators;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\DynamicModel;

use yii\validators\Validator;


class DatesCompareValidator extends Validator
{
    public $params = [
        'from' => 'date_from',
        'to' => 'date_to',
    ];
    
    public function validateAttribute($model, $attribute)
    {
        $message = $this->message ?? Yii::t('app', '{attribute_to} must not be less then {attribute_from}', [
            'attribute_to' => $model->getAttributeLabel($this->params['to']),
            'attribute_from' => $model->getAttributeLabel($this->params['from']),
        ]);
        
        $date_from = $model->{$this->params['from']};
        $date_to = $model->{$this->params['to']};
        
        if (strtotime($date_to) < strtotime($date_from)) {
            return $this->addError($model, $attribute, $message);
        }
    }
}
