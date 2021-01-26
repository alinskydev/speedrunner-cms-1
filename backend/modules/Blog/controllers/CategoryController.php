<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web as Actions;

use backend\modules\Blog\models\BlogCategory;
use backend\modules\Blog\modelsSearch\BlogCategorySearch;


class CategoryController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelSearch' => new BlogCategorySearch(),
            ],
            'create' => [
                'class' => Actions\UpdateAction::className(),
                'model' => new BlogCategory(),
            ],
            'update' => [
                'class' => Actions\UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => Actions\DeleteAction::className(),
                'model' => new BlogCategory(),
            ],
        ];
    }
    
    private function findModel()
    {
        return BlogCategory::findOne(Yii::$app->request->get('id'));
    }
}
