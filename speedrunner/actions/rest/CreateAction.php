<?php

namespace speedrunner\actions\rest;

use Yii;
use yii\helpers\ArrayHelper;


class CreateAction extends FormAction
{
    public $run_method = 'save';
    
    public function run()
    {
        $this->model = $this->model ?? $this->controller->model;
        return parent::run();
    }
}
