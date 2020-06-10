<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;

use backend\modules\Product\models\ProductVariation;
use backend\modules\Product\models\ProductVariationImage;


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
    
    public function actionImageDelete()
    {
        if (($model = ProductVariationImage::findOne(Yii::$app->request->post('key'))) && $model->delete()) {
            return true;
        }
    }
    
    public function actionImageSort($id)
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('sort');
            
            if ($post['oldIndex'] > $post['newIndex']){
                $params = ['and', ['>=', 'sort', $post['newIndex']], ['<', 'sort', $post['oldIndex']]];
                $counter = 1;
            } else {
                $params = ['and', ['<=', 'sort', $post['newIndex']], ['>', 'sort', $post['oldIndex']]];
                $counter = -1;
            }
            
            ProductVariationImage::updateAllCounters(['sort' => $counter], [
               'and', ['item_id' => $id], $params
            ]);
            
            ProductVariationImage::updateAll(['sort' => $post['newIndex']], [
                'id' => $post['stack'][$post['newIndex']]['key']
            ]);
            
            return true;
        }
    }
}
