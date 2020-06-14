<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Blog\models\BlogComment;
use backend\modules\Blog\modelsSearch\BlogCommentSearch;


class CommentController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new BlogCommentSearch);
    }
    
    public function actionView($id)
    {
        if (!($model = BlogComment::findOne($id))) {
            return $this->redirect(['index']);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        }
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new BlogComment);
    }
}
