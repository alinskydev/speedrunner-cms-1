<?php

namespace speedrunner\actions\rest;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class DeleteAction extends Action
{
    public ?Model $model;
    
    public function run($id)
    {
        $this->model = $this->model ?? $this->controller->findModel($id);
        
        if ($this->model) {
            return (bool)$this->model->delete();
        } else {
            throw new \yii\web\NotFoundHttpException('Entity not found');
        }
    }
}
