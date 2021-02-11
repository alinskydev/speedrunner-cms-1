<?php

namespace common\actions\web;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class ItemsListAction extends Action
{
    public Model $model;
    public string $attribute;
    public string $type;
    public ?string $q;
    public int $limit = 20;
    public array $filter = [];
    
    public function run()
    {
        $this->q = $this->q ?? Yii::$app->request->get('q');
        
        $query = $this->model->find()
            ->itemsList($this->attribute, $this->type, $this->q, $this->limit)
            ->andFilterWhere($this->filter);
        
        return $this->controller->asJson([
            'results' => $query->asArray()->all(),
        ]);
    }
}
