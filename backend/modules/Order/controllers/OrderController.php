<?php

namespace backend\modules\Order\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web as Actions;

use backend\modules\Order\models\Order;
use backend\modules\Order\modelsSearch\OrderSearch;


class OrderController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelSearch' => new OrderSearch(),
            ],
            'update' => [
                'class' => Actions\UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => Actions\DeleteAction::className(),
                'model' => new Order(),
            ],
        ];
    }
    
    private function findModel()
    {
        return Order::find()->with(['products'])->andWhere(['id' => Yii::$app->request->get('id')])->one();
    }
}
