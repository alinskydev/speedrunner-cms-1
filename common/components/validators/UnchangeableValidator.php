<?php

namespace common\components\validators;

use Yii;
use yii\validators\Validator;
use yii\helpers\ArrayHelper;
use yii\base\DynamicModel;


class UnchangeableValidator extends Validator
{
    public $params;
    
    public function validateAttribute($model, $attribute)
    {
        if (!$model->isNewRecord && $model->{$attribute} != ArrayHelper::getValue($model->oldAttributes, $attribute)) {
            $this->addError($model, $attribute, Yii::t('app', 'You cannot change {attribute}', [
                'attribute' => $model->getAttributeLabel($attribute),
            ]));
        }
    }
}