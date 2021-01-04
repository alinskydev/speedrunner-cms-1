<?php

namespace backend\modules\Page\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\Speedrunner\controller\actions\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\Page\models\Page;
use backend\modules\Page\modelsSearch\PageSearch;


class PageController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new PageSearch(),
            ],
            'create' => [
                'class' => UpdateAction::className(),
                'model' => new Page(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new Page(),
            ],
        ];
    }
    
    private function findModel()
    {
        return Page::findOne(Yii::$app->request->get('id'));
    }
}
