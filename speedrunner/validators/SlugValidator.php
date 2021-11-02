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
    public $pattern = '/^[a-zA-Z0-9\-]+$/';
    public $min = 1;
    public $max = 100;
    
    public function validateAttribute($model, $attribute)
    {
        (new UniqueValidator(['message' => $this->message]))->validateAttribute($model, $attribute);
        (new RegularExpressionValidator(['pattern' => $this->pattern, 'message' => $this->message]))->validateAttribute($model, $attribute);
        (new StringValidator(['min' => $this->min, 'max' => $this->max, 'message' => $this->message]))->validateAttribute($model, $attribute);
    }
}
