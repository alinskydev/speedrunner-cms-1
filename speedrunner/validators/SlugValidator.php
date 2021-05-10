<?php

namespace speedrunner\validators;

use Yii;
use yii\helpers\ArrayHelper;

use yii\validators\Validator;
use yii\validators\UniqueValidator;
use yii\validators\RegularExpressionValidator;
use yii\validators\StringValidator;


class SlugValidator extends Validator
{
    public $params = [
        'pattern' => '/^[a-zA-Z0-9\-]+$/',
        'min' => 1,
        'max' => 100,
    ];
    
    public function validateAttribute($model, $attribute)
    {
        (new UniqueValidator())->validateAttribute($model, $attribute);
        (new RegularExpressionValidator(['pattern' => $this->params['pattern']]))->validateAttribute($model, $attribute);
        (new StringValidator(['min' => $this->params['min'], 'max' => $this->params['max']]))->validateAttribute($model, $attribute);
    }
}
