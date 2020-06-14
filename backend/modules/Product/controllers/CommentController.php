<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Product\models\ProductComment;
use backend\modules\Product\modelsSearch\ProductCommentSearch;


class CommentController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new ProductCommentSearch);
    }
    
    public function actionView($id)
    {
        if (!($model = ProductComment::findOne($id))) {
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
        return Yii::$app->sr->record->deleteModel(new ProductComment);
    }
}
