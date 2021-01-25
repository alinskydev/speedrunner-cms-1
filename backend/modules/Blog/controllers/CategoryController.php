<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\Blog\models\BlogCategory;
use backend\modules\Blog\modelsSearch\BlogCategorySearch;


class CategoryController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new BlogCategorySearch(),
            ],
            'create' => [
                'class' => UpdateAction::className(),
                'model' => new BlogCategory(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new BlogCategory(),
            ],
        ];
    }
    
    private function findModel()
    {
        return BlogCategory::findOne(Yii::$app->request->get('id'));
    }
}
