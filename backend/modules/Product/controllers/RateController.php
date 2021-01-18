<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\Speedrunner\controller\actions\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\Product\models\ProductRate;
use backend\modules\Product\modelsSearch\ProductRateSearch;


class RateController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new ProductRateSearch(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new ProductRate(),
            ],
        ];
    }
}
