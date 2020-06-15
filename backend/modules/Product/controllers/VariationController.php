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
                return true;
            }
            
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        } else {
            $this->redirect(['product/index']);
        }
    }
    
    public function actionImageDelete($id)
    {
        if (!($model = ProductVariation::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->images;
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            Yii::$app->sr->file->delete($images[$key]);
            unset($images[$key]);
            
            return $model->updateAttributes(['images' => array_values($images)]);
        }
    }
    
    public function actionImageSort($id)
    {
        if (!($model = ProductVariation::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->images;
        $stack = Yii::$app->request->post('sort')['stack'];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        return $model->updateAttributes(['images' => array_values($images)]);
    }
}
