<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web as Actions;

use backend\modules\Blog\models\BlogComment;
use backend\modules\Blog\modelsSearch\BlogCommentSearch;


class CommentController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelSearch' => new BlogCommentSearch(),
            ],
            'delete' => [
                'class' => Actions\DeleteAction::className(),
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
