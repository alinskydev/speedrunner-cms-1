<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\Blog\models\BlogTag;
use backend\modules\Blog\modelsSearch\BlogTagSearch;


class TagController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new BlogTagSearch(),
            ],
            'create' => [
                'class' => UpdateAction::className(),
                'model' => new BlogTag(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new BlogTag(),
            ],
        ];
    }
    
    private function findModel()
    {
        return BlogTag::findOne(Yii::$app->request->get('id'));
    }
}
