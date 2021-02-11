<?php

namespace common\actions\crud;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class FileSortAction extends Action
{
    public array $allowed_attributes = [];
    
    public function run()
    {
        $attr = Yii::$app->request->get('attr');
        
        if (!in_array($attr, $this->allowed_attributes)) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        if (!($model = $this->controller->findModel())) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        $stack = Yii::$app->request->post('sort')['stack'] ?? [];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        return $model->updateAttributes([$attr => array_values($images)]);
    }
}
