<?php

namespace backend\modules\Order\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Order\models\Order;
use backend\modules\Order\search\OrderSearch;


class OrderController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new Order();
        $this->modelSearch = new OrderSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
    }
    
    public function findModel()
    {
        return Order::find()->with(['products'])->andWhere(['id' => Yii::$app->request->get('id')])->one();
    }
}
