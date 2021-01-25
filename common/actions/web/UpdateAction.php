<?php

namespace common\actions\web;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class UpdateAction extends Action
{
    public $model;
    public $view = 'update';
    public array $params = [];
    
    public function run()
    {
        if (!$this->model) {
            return Yii::$app->controller->redirect(['index']);
        }
        
        if ($this->model->load(Yii::$app->request->post()) && $this->model->save()) {
            if (Yii::$app->request->get('reload-page')) {
                return Yii::$app->controller->redirect(['update', 'id' => $this->model->id]);
            } else {
                return Yii::$app->controller->redirect(['index']);
            }
        }
        
        $params = ['model' => $this->model];
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        
        return Yii::$app->controller->{$render_type}($this->view, ArrayHelper::merge($params, $this->params));
    }
}
