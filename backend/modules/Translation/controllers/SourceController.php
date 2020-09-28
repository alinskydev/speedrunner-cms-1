<?php

namespace backend\modules\Translation\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Translation\models\TranslationSource;
use backend\modules\Translation\modelsSearch\TranslationSourceSearch;


class SourceController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new TranslationSourceSearch);
    }
    
    public function actionUpdate($id)
    {
        $model = TranslationSource::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
}
