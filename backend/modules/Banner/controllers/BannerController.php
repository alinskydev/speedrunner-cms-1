<?php

namespace backend\modules\Banner\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\Banner\models\Banner;
use backend\modules\Banner\modelsSearch\BannerSearch;


class BannerController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new BannerSearch(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
            ],
        ];
    }
    
    private function findModel()
    {
        return Banner::find()->with(['groups'])->andWhere(['id' => Yii::$app->request->get('id')])->one();
    }
}
