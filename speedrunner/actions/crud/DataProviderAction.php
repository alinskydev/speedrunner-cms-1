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
        $modelSearch = $this->controller->modelSearch;
        $modelSearch->load(Yii::$app->request->queryParams);
        $modelSearch->beforeSearch();
        
        $render_params = [
            'modelSearch' => $modelSearch,
            'dataProvider' => $modelSearch->search(),
        ];
        
        $modelSearch->afterSearch();
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        
        return $this->controller->{$render_type}($this->render_view, ArrayHelper::merge($render_params, $this->render_params));
    }
}
