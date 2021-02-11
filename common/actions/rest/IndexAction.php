<?php

namespace common\actions\rest;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class IndexAction extends Action
{
    public $modelSearch;
    public array $render_params = [];
    
    public function run()
    {
        $dataProvider = $this->modelSearch->search([$this->modelSearch->formName() => Yii::$app->request->get('filter')]);
        
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
