<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\Speedrunner\controller\actions\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\Product\models\ProductComment;
use backend\modules\Product\modelsSearch\ProductCommentSearch;


class CommentController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new ProductCommentSearch(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new ProductComment(),
            ],
        ];
    }
    
    public function actionView($id)
    {
        if (!($model = ProductComment::findOne($id))) {
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
