<?php

namespace speedrunner\actions\rest;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class FormAction extends Action
{
    public Model $model;
    public string $model_class;
    public array $model_params = [];
    public array $model_files = [];
    
    public $run_method;
    
    public function run()
    {
        $this->model = $this->model ?? new $this->model_class($this->model_params);
        $this->model->load([$this->model->formName() => Yii::$app->request->post()]);
        
        foreach ($this->model_files as $file) {
            if (isset($_FILES[$file])) {
                foreach ($_FILES[$file] as $f_key => $f) {
                    $_FILES[$this->model->formName()][$f_key][$file] = $f;
                }
                
                unset($_FILES[$file]);
            }
        }
        
        if ($this->model->validate()) {
            return call_user_func([$this->model, $this->run_method]);
        } else {
            Yii::$app->response->statusCode = 422;
            
            return [
                'name' => 'Unprocessable entity',
                'message' => $this->model->errors,
                'code' => 0,
                'status' => 422,
                'type' => 'yii\\web\\UnprocessableEntityHttpException',
            ];
        }
    }
}
