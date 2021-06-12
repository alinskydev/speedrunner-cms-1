<?php

namespace speedrunner\actions\crud;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class FileDeleteAction extends Action
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
        
        $images = is_array($model->{$attr}) ? $model->{$attr} : [$model->{$attr}];
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            Yii::$app->services->file->delete($images[$key]);
            unset($images[$key]);
            
            return $model->updateAttributes([
                $attr => is_array($model->{$attr}) ? array_values($images) : '',
            ]);
        }
    }
}
