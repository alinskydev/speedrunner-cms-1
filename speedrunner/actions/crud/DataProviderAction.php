<?php

namespace speedrunner\actions\crud;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class DataProviderAction extends Action
{
    public $render_view = 'index';
    public ?\Closure $render_params;
    
    public function run()
    {
        $params = Yii::$app->request->queryParams;
        array_walk_recursive($params, fn (&$v) => $v = trim($v));
        
        $model = $this->controller->model->searchModel;
        $model->enums = $this->controller->model->enums;
        $model->load($params);
        $model->beforeSearch();
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        $render_params = $this->render_params ?? fn () => [];
        
        $model->afterSearch();
        
        return call_user_func(
            [$this->controller, $render_type],
            $this->render_view,
            ArrayHelper::merge([
                'searchModel' => $model,
                'dataProvider' => $model->search(),
            ], $render_params())
        );
    }
}
