<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Product\models\ProductAttribute;
use backend\modules\Product\modelsSearch\ProductAttributeSearch;


class AttributeController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new ProductAttributeSearch);
    }
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new ProductAttribute);
    }
    
    public function actionUpdate($id)
    {
        $model = ProductAttribute::find()->with(['options'])->where(['id' => $id])->one();
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new ProductAttribute);
    }
    
    public function actionItemsList($q = '')
    {
        $out['results'] = ProductAttribute::itemsList('name', 'translation', 20, $q);
        return $this->asJson($out);
    }
}
