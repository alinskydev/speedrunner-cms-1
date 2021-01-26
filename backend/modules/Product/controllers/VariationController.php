<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\ProductVariation;


class VariationController extends Controller
{
    public function actions()
    {
        return [
            'image-sort' => [
                'class' => Actions\ImageSortAction::className(),
                'model' => $this->findModel(),
                'allowed_attributes' => ['images'],
            ],
            'image-delete' => [
                'class' => Actions\ImageDeleteAction::className(),
                'model' => $this->findModel(),
                'allowed_attributes' => ['images'],
            ],
        ];
    }
    
    private function findModel()
    {
        return ProductVariation::findOne(Yii::$app->request->get('id'));
    }
    
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
}
