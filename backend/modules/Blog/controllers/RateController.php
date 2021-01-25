<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\Blog\models\BlogRate;
use backend\modules\Blog\modelsSearch\BlogRateSearch;


class RateController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new BlogRateSearch(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new BlogRate(),
            ],
        ];
    }
}
