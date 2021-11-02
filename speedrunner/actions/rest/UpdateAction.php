<?php

namespace speedrunner\actions\rest;

use Yii;
use yii\helpers\ArrayHelper;


class UpdateAction extends FormAction
{
    public $run_method = 'save';
    
    public function run($id = null)
    {
        $this->model = $this->model ?? $this->controller->findModel($id);
        
        if ($this->model) {
            $this->model->setTranslations();
            return parent::run();
        } else {
            throw new \yii\web\NotFoundHttpException('Entity not found');
        }
    }
}
