<?php

namespace backend\modules\Product\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\ProductSpecification;
use backend\modules\Product\modelsSearch\ProductSpecificationSearch;


class SpecificationController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new ProductSpecification();
        $this->modelSearch = new ProductSpecificationSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
    }
    
    public function findModel()
    {
        return ProductSpecification::find()->with(['options'])->andWhere(['id' => Yii::$app->request->get('id')])->one();
    }
}
