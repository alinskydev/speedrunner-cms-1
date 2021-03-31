<?php

namespace speedrunner\actions\web;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class SortAction extends Action
{
    public string $model_class;
    
    public array $params = [
        'id' => 'id',
        'old_index' => 'old_index',
        'new_index' => 'new_index',
        'sort' => 'sort',
    ];
    
    public function run()
    {
        $model = new $this->model_class();
        
        $id = Yii::$app->request->post($this->params['id']);
        $old_index = Yii::$app->request->post($this->params['old_index']);
        $new_index = Yii::$app->request->post($this->params['new_index']);
        
        if ($old_index === null || $new_index === null) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if ($old_index > $new_index) {
            $filter = ['and', ['>=', $this->params['sort'], $new_index], ['<', $this->params['sort'], $old_index]];
            $counter = 1;
        } else {
            $filter = ['and', ['<=', $this->params['sort'], $new_index], ['>', $this->params['sort'], $old_index]];
            $counter = -1;
        }
        
        $model->updateAllCounters([$this->params['sort'] => $counter], $filter);
        $model->updateAll([$this->params['sort'] => $new_index], [$this->params['id'] => $id]);
    }
}
