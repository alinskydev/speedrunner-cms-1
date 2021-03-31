<?php

namespace speedrunner\validators;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\DynamicModel;

use yii\validators\Validator;


class UnchangeableValidator extends Validator
{
    public $params;
    
    public function validateAttribute($model, $attribute)
    {
        $message = $this->message ?? Yii::t('app', 'You cannot change {attribute}', [
            'attribute' => $model->getAttributeLabel($attribute),
        ]);
        
        if (!$model->isNewRecord && $model->{$attribute} != ArrayHelper::getValue($model->oldAttributes, $attribute)) {
            return $this->addError($model, $attribute, $message);
        }
    }
}
