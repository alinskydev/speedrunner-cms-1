<?php

namespace backend\modules\Product\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\ProductBrand;
use backend\modules\Product\search\ProductBrandSearch;


class BrandController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new ProductBrand();
        $this->modelSearch = new ProductBrandSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
    }
    
    public function findModel()
    {
        return ProductBrand::findOne(Yii::$app->request->get('id'));
    }
}
