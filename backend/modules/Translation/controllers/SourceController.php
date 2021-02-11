<?php

namespace backend\modules\Translation\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Translation\models\TranslationSource;
use backend\modules\Translation\modelsSearch\TranslationSourceSearch;


class SourceController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new TranslationSource();
        $this->modelSearch = new TranslationSourceSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'update']);
    }
    
    public function findModel()
    {
        return TranslationSource::find()->with(['translations'])->andWhere(['id' => Yii::$app->request->get('id')])->one();
    }
}
