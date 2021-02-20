<?php

namespace speedrunner\bootstrap;
 
use Yii;
use yii\helpers\ArrayHelper;


class Components
{
    public $components;
    
    public function __get($name)
    {
        if ($service = ArrayHelper::getValue($this->components, $name)) {
            return new $service;
        } else {
            throw new \yii\web\HttpException(404, "The requested component '$name' not found");
        }
    }
}