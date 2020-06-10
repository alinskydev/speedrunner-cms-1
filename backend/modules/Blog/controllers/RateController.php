<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Blog\models\BlogRate;
use backend\modules\Blog\modelsSearch\BlogRateSearch;


class RateController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new BlogRateSearch);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new BlogRate);
    }
}
