<?php

namespace common\actions\crud;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class IndexAction extends Action
{
    public $render_view = 'index';
    public array $render_params = [];
    
    public function run()
    {
        $modelSearch = $this->controller->modelSearch;
        
        $render_params = [
            'modelSearch' => $modelSearch,
            'dataProvider' => $modelSearch->search(Yii::$app->request->queryParams),
        ];
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        
        return $this->controller->{$render_type}($this->render_view, ArrayHelper::merge($render_params, $this->render_params));
    }
}
