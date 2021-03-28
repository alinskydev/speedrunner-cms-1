<?php

namespace backend\modules\Order\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Order\models\Order;


class OrderController extends CrudController
{
    public function init()
    {
        $this->model = new Order();
        return parent::init();
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
    }
    
    public function findModel($id)
    {
        return $this->model->find()->with(['products.product'])->andWhere(['id' => $id])->one();
    }
    
    public function actionChangeStatus($id, $status)
    {
        if (!($model = $this->model->findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $model->service->changeStatus($status);
        return $this->redirect(Yii::$app->request->referrer);
    }
}
