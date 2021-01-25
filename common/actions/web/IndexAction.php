<?php

namespace common\actions\web;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class IndexAction extends Action
{
    public $modelSearch;
    public $view = 'index';
    public array $params = [];
    
    public function run()
    {
        $params = [
            'modelSearch' => $this->modelSearch,
            'dataProvider' => $this->modelSearch->search(Yii::$app->request->queryParams),
        ];
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        
        return Yii::$app->controller->{$render_type}($this->view, ArrayHelper::merge($params, $this->params));
    }
}
