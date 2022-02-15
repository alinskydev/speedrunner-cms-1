<?php

namespace speedrunner\actions\rest;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class FileDeleteAction extends Action
{
    public array $allowed_attributes = [];

    public function run($id, $attr)
    {
        if (!in_array($attr, $this->allowed_attributes)) {
            throw new \yii\web\NotFoundHttpException('Attribute not found');
        }

        if (!($model = $this->controller->findModel($id))) {
            throw new \yii\web\NotFoundHttpException('Entity not found');
        }

        $images = is_array($model->{$attr}) ? $model->{$attr} : [$model->{$attr}];
        $key = array_search(Yii::$app->request->post('key'), $images);

        if ($key === false) {
            throw new \yii\web\NotFoundHttpException('Key not found');
        }

        Yii::$app->services->file->delete($images[$key]);
        unset($images[$key]);

        return $model->updateAttributes([
            $attr => is_array($model->{$attr}) ? array_values($images) : '',
        ]);
    }
}
