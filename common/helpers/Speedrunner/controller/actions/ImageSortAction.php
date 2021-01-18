<?php

namespace common\helpers\Speedrunner\controller\actions;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class ImageSortAction extends Action
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
        
        $stack = Yii::$app->request->post('sort')['stack'] ?? [];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        return $this->model->updateAttributes([
            $attr => array_values($images),
        ]);
    }
}
