<?php

namespace common\bootstrap;
 
use Yii;
use yii\helpers\ArrayHelper;


class Services
{
    public $services;
    
    public function __get($name)
    {
        if ($service = ArrayHelper::getValue($this->services, $name)) {
            return new $service;
        } else {
            throw new \yii\web\HttpException(404, "The requested service '$name' not found");
        }
    }
}