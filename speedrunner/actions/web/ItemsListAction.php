<?php

namespace speedrunner\actions\web;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class ItemsListAction extends Action
{
    public Model $model;
    public string $model_class;
    
    public string $attribute;
    public string $type;
    public string $query_param = 'q';
    public int $limit = 20;
    
    public array $filter = [];
    
    public function run()
    {
        $this->model = $this->model ?? new $this->model_class();
        
        $query = $this->model->find()
            ->itemsList($this->attribute, $this->type, Yii::$app->request->get($this->query_param), $this->limit)
            ->andFilterWhere($this->filter);
        
        return $this->controller->asJson([
            'results' => $query->asArray()->all(),
        ]);
    }
}
