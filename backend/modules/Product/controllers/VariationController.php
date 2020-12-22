<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\ProductVariation;


class VariationController extends Controller
{
    public function actionUpdate($id)
    {
        if ($model = ProductVariation::findOne($id)) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->removeFlash('success');
                return true;
            }
            
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        } else {
            $this->redirect(['product/index']);
        }
    }
    
    public function actionImageSort($id, $attr)
    {
        if (!in_array($attr, ['images'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if (!($model = ProductVariation::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $stack = Yii::$app->request->post('sort')['stack'];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        return $model->updateAttributes([$attr => array_values($images)]);
    }
    
    public function actionImageDelete($id, $attr)
    {
        if (!in_array($attr, ['images'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if (!($model = ProductVariation::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->{$attr};
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            Yii::$app->sr->file->delete($images[$key]);
            unset($images[$key]);
            
            return $model->updateAttributes([$attr => array_values($images)]);
        }
    }
}
