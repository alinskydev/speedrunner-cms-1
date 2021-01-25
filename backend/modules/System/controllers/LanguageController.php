<?php

namespace backend\modules\System\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\System\models\SystemLanguage;
use backend\modules\System\modelsSearch\SystemLanguageSearch;


class LanguageController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new SystemLanguageSearch(),
            ],
            'create' => [
                'class' => UpdateAction::className(),
                'model' => new SystemLanguage(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new SystemLanguage(),
            ],
        ];
    }
    
    private function findModel()
    {
        return SystemLanguage::findOne(Yii::$app->request->get('id'));
    }
}
