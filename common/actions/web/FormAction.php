<?php

namespace common\actions\web;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class FormAction extends Action
{
    public Model $model;
    public string $model_class;
    public array $model_params = [];
    
    public string $render_view;
    public array $render_params = [];
    
    public string $run_method;
    public ?string $success_message = null;
    public $redirect_route = false;
    
    public function run()
    {
        $this->model = $this->model ?? new $this->model_class($this->model_params);
        
        if ($this->model->load(Yii::$app->request->post()) && $this->model->validate()) {
            if (!$this->model->{$this->run_method}()) {
                Yii::$app->session->setFlash('danger', [Yii::t('app', 'An error occurred')]);
            }
            
            if ($this->success_message) {
                Yii::$app->session->setFlash('success', [Yii::t('app', $this->success_message)]);
            }
            
            if (!$this->redirect_route) {
                return true;
            }
            
            if (Yii::$app->request->get('save-and-update')) {
                return $this->controller->redirect(['update', 'id' => $this->model->id]);
            } else {
                return $this->controller->redirect($this->redirect_route);
            }
        }
        
        $render_params = ['model' => $this->model];
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        
        return $this->controller->{$render_type}($this->render_view, ArrayHelper::merge($render_params, $this->render_params));
    }
}
