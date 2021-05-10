<?php

namespace backend\modules\Product\controllers;

use Yii;
use speedrunner\controllers\NestedSetsController;
use speedrunner\actions as Actions;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\ProductCategory;


class CategoryController extends NestedSetsController
{
    public function init()
    {
        $this->model = new ProductCategory();
        return parent::init();
    }
    
    public function findModel($id)
    {
        return $this->model->find()->with(['specifications'])->withoutRoots()->andWhere(['id' => $id])->one();
    }
}
