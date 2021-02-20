<?php

namespace backend\modules\Product\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\ProductSpecification;


class SpecificationController extends CrudController
{
    public function init()
    {
        $this->model = new ProductSpecification();
        return parent::init();
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
    }
    
    public function findModel($id)
    {
        return ProductSpecification::find()->with(['options'])->andWhere(['id' => $id])->one();
    }
}
