<?php

namespace backend\modules\System\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\System\models\SystemLanguage;
use backend\modules\System\search\SystemLanguageSearch;


class LanguageController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new SystemLanguage();
        $this->modelSearch = new SystemLanguageSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
    }
    
    public function findModel()
    {
        return SystemLanguage::findOne(Yii::$app->request->get('id'));
    }
}
