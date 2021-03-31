<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use frontend\forms\OrderForm;

use backend\modules\Order\models\Order;


class OrderController extends Controller
{
    public function actionView($key)
    {
        $model = Order::find()->with(['products'])->andWhere(['key' => $key])->one();
        
        if (!$model) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new OrderForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($key = $model->save()) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'order_create_success_alert'));
                return $this->redirect(['view', 'key' => $key]);
            } else {
                Yii::$app->session->addFlash('danger', Yii::t('app', 'An error occurred'));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }
}
