<?php

namespace speedrunner\actions\rest;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;


class DataProviderAction extends Action
{
    public ActiveRecord $model;
    public array $render_params = [];
    
    public function run()
    {
        $params = Yii::$app->request->get('filter');
        array_walk_recursive($params, function(&$v) { $v = trim($v); });
        
        $this->model = $this->model->searchModel;
        $this->model->load([$this->model->formName() => $params]);
        $this->model->beforeSearch();
        
        $dataProvider = $this->model->search();
        $dataProvider->pagination->totalCount = $dataProvider->query->count();
        
        $this->model->afterSearch();
        
        $render_params = [
            'data' => $dataProvider,
            'links' => $dataProvider->pagination->getLinks(true),
            'pagination' => [
                'total_count' => (int)$dataProvider->pagination->totalCount,
                'page_count' => $dataProvider->pagination->pageCount,
                'current_page' => $dataProvider->pagination->page + 1,
                'page_size' => $dataProvider->pagination->pageSize,
            ],
        ];
        
        return ArrayHelper::merge($render_params, $this->render_params);
    }
}
