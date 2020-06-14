<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Blog\models\BlogTag;
use backend\modules\Blog\modelsSearch\BlogTagSearch;


class TagController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new BlogTagSearch);
    }
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new BlogTag);
    }
    
    public function actionUpdate($id)
    {
        $model = BlogTag::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new BlogTag);
    }
    
    public function actionItemsList($q = '')
    {
        $out['results'] = BlogTag::itemsList('name', 'self', 20, $q);
        return $this->asJson($out);
    }
}
