<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\Blog\models\BlogComment;
use backend\modules\Blog\modelsSearch\BlogCommentSearch;


class CommentController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new BlogCommentSearch(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new BlogComment(),
            ],
        ];
    }
    
    public function actionView($id)
    {
        if (!($model = BlogComment::findOne($id))) {
            return $this->redirect(['index']);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
