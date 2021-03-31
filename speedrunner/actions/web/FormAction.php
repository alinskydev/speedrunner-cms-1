<?php

namespace speedrunner\actions\web;

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
    public ?\Closure $render_params;
    
    public string $run_method;
    
    public ?string $success_message = null;
    public ?string $error_message = 'An error occurred';
    
    public $redirect_route = null;
    
    public function run()
    {
        $this->model = $this->model ?? new $this->model_class($this->model_params);
        
        if ($this->model->load(Yii::$app->request->post()) && $this->model->validate()) {
            if (call_user_func([$this->model, $this->run_method])) {
                if ($this->success_message) {
                    Yii::$app->session->addFlash('success', Yii::t('app', $this->success_message));
                }
            } else {
                if ($this->error_message) {
                    Yii::$app->session->addFlash('danger', Yii::t('app', $this->error_message));
                }
            }
            
            if (!$this->redirect_route) {
                return false;
            }
            
            if (Yii::$app->request->get('save-and-update')) {
                return $this->controller->redirect(['update', 'id' => $this->model->id]);
            } else {
                return $this->controller->redirect($this->redirect_route);
            }
        }
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        $render_params = $this->render_params ?? fn () => [];
        
        return call_user_func(
            [$this->controller, $render_type],
            $this->render_view,
            ArrayHelper::merge([
                'model' => $this->model,
            ], $render_params())
        );
    }
}
