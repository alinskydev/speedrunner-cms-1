<?php

namespace speedrunner\actions\crud;

use Yii;
use speedrunner\actions\web\FormAction;
use yii\helpers\ArrayHelper;


class CreateAction extends FormAction
{
    public ?string $render_view = 'update';
    
    public string $run_method = 'save';
    
    public ?string $success_message = 'Record has been saved';
    
    public $redirect_route = ['index'];
    
    public function run()
    {
        $this->model = $this->model ?? $this->controller->model;
        return parent::run();
    }
}
