<?php

namespace speedrunner\validators;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\DynamicModel;

use yii\validators\Validator;
use yii\validators\UniqueValidator;
use yii\validators\RegularExpressionValidator;
use yii\validators\StringValidator;


class SlugValidator extends Validator
{
    public $params = [
        'pattern' => '/^[a-zA-Z0-9\-]+$/',
        'max' => 100,
    ];
    
    public function validateAttribute($model, $attribute)
    {
        (new UniqueValidator())->validateAttribute($model, $attribute);
        (new RegularExpressionValidator(['pattern' => $this->params['pattern']]))->validateAttribute($model, $attribute);
        (new StringValidator(['max' => 100]))->validateAttribute($model, $attribute);
    }
}
