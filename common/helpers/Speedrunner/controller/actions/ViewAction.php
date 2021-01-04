<?php

namespace common\helpers\Speedrunner\controller\actions;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class ViewAction extends Action
{
    public $model;
    public $view = 'view';
    public array $params = [];
    
    public function run()
    {
        if (!$this->model) {
            return Yii::$app->controller->redirect(['index']);
        }
        
        $params = ['model' => $this->model];
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        
        return Yii::$app->controller->{$render_type}($this->view, ArrayHelper::merge($params, $this->params));
    }
}
