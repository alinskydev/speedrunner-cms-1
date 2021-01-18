<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;

use backend\modules\Product\models\ProductRate;
use backend\modules\Product\modelsSearch\ProductRateSearch;


class RateController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new ProductRateSearch);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new ProductRate);
    }
}
