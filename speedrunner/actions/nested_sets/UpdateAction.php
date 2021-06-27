<?php

namespace speedrunner\actions\nested_sets;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class UpdateAction extends Action
{
    public array $model_params = [];
    
    public string $render_view = 'update';
    public ?\Closure $render_params;
    
    public ?string $success_message = 'Record has been saved';
    public ?string $error_message = 'An error occurred';
    
    public $redirect_route = ['tree'];
    
    public function run($id)
    {
        if (!($model = $this->controller->findModel($id))) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        $model->setAttributes($this->model_params, false);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
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
            
            return $this->controller->redirect($this->redirect_route);
        }
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        $render_params = $this->render_params ?? fn() => [];
        
        return $this->controller->{$render_type}(
            $this->render_view,
            ArrayHelper::merge(['model' => $model], $render_params())
        );
    }
}
