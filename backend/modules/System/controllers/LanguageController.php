<?php

namespace backend\modules\System\controllers;

use Yii;
use yii\web\Controller;

use backend\modules\System\models\SystemLanguage;
use backend\modules\System\modelsSearch\SystemLanguageSearch;


class LanguageController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new SystemLanguageSearch);
    }
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new SystemLanguage);
    }
    
    public function actionUpdate($id)
    {
        $model = SystemLanguage::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
    public function actionDelete($id)
    {
        return Yii::$app->sr->record->deleteModel(new SystemLanguage);
    }
}
