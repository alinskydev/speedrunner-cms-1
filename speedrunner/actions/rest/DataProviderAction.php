<?php

namespace speedrunner\actions\rest;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class DataProviderAction extends Action
{
    public Model $model;
    public string $model_class;
    public array $model_params = [];
    
    public ?\Closure $render_params;
    
    public function run()
    {
        $this->model = $this->model ?? new $this->model_class($this->model_params);
        
        $params = Yii::$app->request->get('filter', []);
        array_walk_recursive($params, fn (&$v) => $v = trim($v));
        
        $this->model = $this->model->searchModel;
        $this->model->load([$this->model->formName() => $params]);
        $this->model->beforeSearch();
        
        $dataProvider = $this->model->search();
        $dataProvider->pagination->totalCount = $dataProvider->query->count();
        
        $render_params = $this->render_params ?? fn () => [];
        
        $this->model->afterSearch();
        
        return ArrayHelper::merge([
            'data' => $dataProvider,
            'links' => $dataProvider->pagination->getLinks(true),
            'pagination' => [
                'total_count' => (int)$dataProvider->pagination->totalCount,
                'page_count' => $dataProvider->pagination->pageCount,
                'current_page' => $dataProvider->pagination->page + 1,
                'page_size' => $dataProvider->pagination->pageSize,
            ],
        ], $render_params());
    }
}
