<?php

namespace backend\modules\Zzz\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Zzz\models\ZzzCategory;
use backend\modules\Zzz\modelsSearch\ZzzCategorySearch;


class CategoryController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new ZzzCategorySearch);
    }
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new ZzzCategory);
    }
    
    public function actionUpdate($id)
    {
        $model = ZzzCategory::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new ZzzCategory);
    }
}
