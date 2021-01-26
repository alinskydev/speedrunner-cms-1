<?php

namespace backend\modules\Page\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web as Actions;

use backend\modules\Page\models\Page;
use backend\modules\Page\modelsSearch\PageSearch;


class PageController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelSearch' => new PageSearch(),
            ],
            'create' => [
                'class' => Actions\UpdateAction::className(),
                'model' => new Page(),
            ],
            'update' => [
                'class' => Actions\UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => Actions\DeleteAction::className(),
                'model' => new Page(),
            ],
        ];
    }
    
    private function findModel()
    {
        return Page::findOne(Yii::$app->request->get('id'));
    }
}
