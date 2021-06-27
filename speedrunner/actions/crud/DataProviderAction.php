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
        
        $searchModel = $this->controller->model->searchModel;
        $searchModel->enums = $this->controller->model->enums;
        $searchModel->load($params);
        $searchModel->beforeSearch();
        
        $dataProvider = $searchModel->search();
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        $render_params = $this->render_params ?? fn() => [];
        
        $searchModel->afterSearch();
        
        return $this->controller->{$render_type}(
            $this->render_view,
            ArrayHelper::merge([
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ], $render_params())
        );
    }
}
