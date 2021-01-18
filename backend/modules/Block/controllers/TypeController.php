<?php

namespace backend\modules\Block\controllers;

use Yii;
use yii\web\Controller;

use backend\modules\Block\models\BlockType;
use backend\modules\Block\modelsSearch\BlockTypeSearch;


class TypeController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new BlockTypeSearch);
    }
    
    public function actionUpdate($id)
    {
        $model = BlockType::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
}
