<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Product\models\ProductSpecification;
use backend\modules\Product\modelsSearch\ProductSpecificationSearch;


class SpecificationController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new ProductSpecificationSearch);
    }
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new ProductSpecification);
    }
    
    public function actionUpdate($id)
    {
        $model = ProductSpecification::find()->with(['options'])->andWhere(['id' => $id])->one();
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new ProductSpecification);
    }
    
    public function actionItemsList($q = null)
    {
        $out['results'] = ProductSpecification::itemsList('name', 'translation', $q)->asArray()->all();
        return $this->asJson($out);
    }
}
