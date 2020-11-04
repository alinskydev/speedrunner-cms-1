<?php

namespace backend\modules\Log\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\Log\models\LogAction;
use backend\modules\Log\modelsSearch\LogActionSearch;


class ActionController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new LogActionSearch);
    }
    
    public function actionView($id)
    {
        $model = LogAction::find()->with(['attrs'])->andWhere(['id' => $id])->one();
        
        if (!$model) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        return $this->renderAjax('view', [
            'model' => $model,
        ]);
    }
}
