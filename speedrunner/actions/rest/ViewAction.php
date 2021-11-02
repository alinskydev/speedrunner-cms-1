<?php

namespace speedrunner\actions\rest;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class ViewAction extends Action
{
    public ?Model $model;
    
    public function run($id = null)
    {
        $this->model = $this->model ?? $this->controller->findModel($id);
        
        if ($this->model) {
            return $this->model;
        } else {
            throw new \yii\web\NotFoundHttpException('Entity not found');
        }
    }
}
