<?php

namespace backend\modules\Order\controllers;

use Yii;
use yii\web\Controller;
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
        if (!($model = Order::find()->with(['products'])->andWhere(['id' => $id])->one())) {
            return $this->redirect(['index']);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->get('reload-page')) {
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                return $this->redirect(['index']);
            }
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
