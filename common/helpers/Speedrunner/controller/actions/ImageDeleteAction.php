<?php

namespace common\helpers\Speedrunner\controller\actions;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


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
            Yii::$app->sr->file->delete($images[$key]);
            unset($images[$key]);
            
            return $this->model->updateAttributes([$attr => array_values($images)]);
        }
    }
}
