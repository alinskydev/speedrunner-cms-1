<?php

namespace speedrunner\actions\rest;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class DataProviderAction extends Action
{
    public ?Model $model;
    public ?\Closure $render_params;
    
    public function run()
    {
        $this->model = $this->model ?? $this->controller->model;
        
        $params = Yii::$app->request->get('filter', []);
        array_walk_recursive($params, fn(&$v) => $v = trim($v));
        
        $this->model = $this->model->searchModel;
        $this->model->load([$this->model->formName() => $params]);
        $this->model->beforeSearch();
        
        $dataProvider = $this->model->search();
        $dataProvider->pagination->totalCount = $dataProvider->query->count();
        
        $render_params = $this->render_params ?? fn() => [];
        
        $this->model->afterSearch();
        
        return ArrayHelper::merge([
            'data' => $dataProvider,
        ], $render_params());
    }
}
