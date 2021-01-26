<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web as Actions;

use backend\modules\Blog\models\BlogTag;
use backend\modules\Blog\modelsSearch\BlogTagSearch;


class TagController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelSearch' => new BlogTagSearch(),
            ],
            'create' => [
                'class' => Actions\UpdateAction::className(),
                'model' => new BlogTag(),
            ],
            'update' => [
                'class' => Actions\UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => Actions\DeleteAction::className(),
                'model' => new BlogTag(),
            ],
        ];
    }
    
    private function findModel()
    {
        return BlogTag::findOne(Yii::$app->request->get('id'));
    }
}
