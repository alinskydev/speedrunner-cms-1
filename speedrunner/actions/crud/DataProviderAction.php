<?php

namespace speedrunner\actions\crud;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class DataProviderAction extends Action
{
    public $render_view = 'index';
    public array $render_params = [];
    
    public function run()
    {
        $params = Yii::$app->request->queryParams;
        array_walk_recursive($params, function(&$v) { $v = trim($v); });
        
        $model = $this->controller->model->searchModel;
        $model->enums = $this->controller->model->enums;
        $model->load($params);
        $model->beforeSearch();
        
        $render_params = [
            'searchModel' => $model,
            'dataProvider' => $model->search(),
        ];
        
        $model->afterSearch();
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        
        return call_user_func(
            [$this->controller, $render_type],
            $this->render_view,
            ArrayHelper::merge($render_params, $this->render_params)
        );
    }
}
