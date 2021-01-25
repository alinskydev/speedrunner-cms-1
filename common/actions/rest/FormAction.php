<?php

namespace common\actions\rest;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class FormAction extends Action
{
    public $form;
    public array $input_params = [];
    public array $file_attributes = [];
    public $run_method;
    
    public function run()
    {
        $form = $this->form ?: $this->controller::FORMS[$this->id];
        
        $model = new $form($this->input_params);
        $model->load([$model->formName() => Yii::$app->request->post()]);
        
        foreach ($this->file_attributes as $f_a) {
            if (isset($_FILES[$f_a])) {
                foreach ($_FILES[$f_a] as $key => $f) {
                    $_FILES[$model->formName()][$key][$f_a] = $f;
                }
                
                unset($_FILES[$f_a]);
            }
        }
        
        if ($model->validate()) {
            return $model->{$this->run_method}();
        } else {
            Yii::$app->response->statusCode = 422;
            
            return [
                'name' => 'Unprocessable entity',
                'message' => $model->errors,
                'code' => 0,
                'status' => 422,
                'type' => 'yii\\web\\UnprocessableEntityHttpException',
            ];
        }
    }
}
