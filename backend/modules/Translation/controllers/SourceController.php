<?php

namespace backend\modules\Translation\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web as Actions;

use backend\modules\Translation\models\TranslationSource;
use backend\modules\Translation\modelsSearch\TranslationSourceSearch;


class SourceController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelSearch' => new TranslationSourceSearch(),
            ],
            'update' => [
                'class' => Actions\UpdateAction::className(),
                'model' => $this->findModel(),
            ],
        ];
    }
    
    private function findModel()
    {
        return TranslationSource::find()->with(['translations'])->andWhere(['id' => Yii::$app->request->get('id')])->one();
    }
}
