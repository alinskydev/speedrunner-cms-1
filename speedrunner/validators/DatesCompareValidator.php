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
        $message = $this->message ?? Yii::t('app', '{attribute_1} must not be less then {attribute_2}', [
            'attribute_1' => $model->getAttributeLabel('date_to'),
            'attribute_2' => $model->getAttributeLabel('date_from'),
        ]);
        
        $date_from = $model->{$this->params['from']};
        $date_to = $model->{$this->params['to']};
        
        if (strtotime($date_to) < strtotime($date_from)) {
            return $this->addError($model, $attribute, $message);
        }
    }
}
