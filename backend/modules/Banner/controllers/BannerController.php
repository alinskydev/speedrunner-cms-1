<?php

namespace backend\modules\Banner\controllers;

use Yii;
use yii\web\Controller;

use backend\modules\Banner\models\Banner;
use backend\modules\Banner\modelsSearch\BannerSearch;


class BannerController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new BannerSearch);
    }
    
    public function actionUpdate($id)
    {
        $model = Banner::find()->with(['groups'])->andWhere(['id' => $id])->one();
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
}
