<?php

namespace backend\modules\Page\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Page\models\Page;
use backend\modules\Page\modelsSearch\PageSearch;


class PageController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new PageSearch);
    }
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new Page);
    }
    
    public function actionUpdate($id)
    {
        $model = Page::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new Page);
    }
}
