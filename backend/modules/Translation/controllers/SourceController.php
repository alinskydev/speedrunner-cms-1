<?php

namespace backend\modules\Translation\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\Speedrunner\controller\actions\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\Translation\models\TranslationSource;
use backend\modules\Translation\modelsSearch\TranslationSourceSearch;


class SourceController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new TranslationSourceSearch(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
            ],
        ];
    }
    
    private function findModel()
    {
        return TranslationSource::findOne(Yii::$app->request->get('id'));
    }
}
