<?php

namespace backend\modules\Blog\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\BlogComment;
use backend\modules\Blog\search\BlogCommentSearch;


class CommentController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new BlogComment();
        $this->modelSearch = new BlogCommentSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'delete']);
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
