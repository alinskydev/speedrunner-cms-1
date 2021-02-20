<?php

namespace speedrunner\actions\crud;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class FileSortAction extends Action
{
    public array $allowed_attributes = [];
    
    public function run($id, $attr)
    {
        if (!in_array($attr, $this->allowed_attributes)) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        if (!($model = $this->controller->findModel($id))) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        $stack = Yii::$app->request->post('sort')['stack'] ?? [];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        return $model->updateAttributes([$attr => array_values($images)]);
    }
}
