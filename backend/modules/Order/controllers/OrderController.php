<?php

namespace backend\modules\Order\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\Order\models\Order;
use backend\modules\Order\modelsSearch\OrderSearch;


class OrderController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new OrderSearch);
    }
    
    public function actionView($id)
    {
        if (!($model = Order::find()->with(['products'])->where(['id' => $id])->one())) {
            return $this->redirect(['index']);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new Order);
    }
}
