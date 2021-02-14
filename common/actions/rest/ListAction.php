<?php

namespace common\actions\rest;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class ListAction extends Action
{
    public $modelSearch;
    public array $render_params = [];
    
    public function run()
    {
        $this->modelSearch->load([$this->modelSearch->formName() => Yii::$app->request->get('filter')]);
        $this->modelSearch->beforeSearch();
        
        $dataProvider = $this->modelSearch->search();
        $dataProvider->pagination->totalCount = $dataProvider->query->count();
        
        $this->modelSearch->afterSearch();
        
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
