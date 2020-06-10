<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Blog\models\BlogCategory;
use backend\modules\Blog\modelsSearch\BlogCategorySearch;


class CategoryController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new BlogCategorySearch);
    }
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new BlogCategory);
    }
    
    public function actionUpdate($id)
    {
        $model = BlogCategory::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new BlogCategory);
    }
    
    public function actionGetSelectionList($q = '')
    {
        $out['results'] = BlogCategory::getSelectionList($q, 'name');
        return $this->asJson($out);
    }
}
