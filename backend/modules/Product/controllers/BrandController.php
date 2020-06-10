<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Product\models\ProductBrand;
use backend\modules\Product\modelsSearch\ProductBrandSearch;


class BrandController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new ProductBrandSearch);
    }
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new ProductBrand);
    }
    
    public function actionUpdate($id)
    {
        $model = ProductBrand::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new ProductBrand);
    }
    
    public function actionGetSelectionList($q = '')
    {
        $out['results'] = ProductBrand::getSelectionList($q, 'name');
        return $this->asJson($out);
    }
}
