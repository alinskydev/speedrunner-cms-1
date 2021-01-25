<?php

namespace common\actions\web;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use common\services\FileService;


class ImageDeleteAction extends Action
{
    public $model;
    public array $allowed_attributes = [];
    
    public function run()
    {
        $attr = Yii::$app->request->get('attr');
        
        if (!in_array($attr, $this->allowed_attributes)) {
            return Yii::$app->controller->redirect(Yii::$app->request->referrer);
        }
        
        if (!$this->model) {
            return Yii::$app->controller->redirect(Yii::$app->request->referrer);
        }
        
        $images = $this->model->{$attr};
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            FileService::delete($images[$key]);
            unset($images[$key]);
            
            return $this->model->updateAttributes([$attr => array_values($images)]);
        }
    }
}
