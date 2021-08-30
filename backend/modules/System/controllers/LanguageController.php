<?php

namespace backend\modules\System\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\System\models\SystemLanguage;


class LanguageController extends CrudController
{
    public function init()
    {
        $this->model = new SystemLanguage();
        return parent::init();
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
    }
    
    public function actionSetMain($id)
    {
        if ($model = $this->findModel($id)) {
            $model->is_main = 1;
            $model->save();
            
            Yii::$app->session->addFlash('success', Yii::t('app', 'Main language has been changed'));
        }
        
        return $this->redirect(Yii::$app->request->referrer);
    }
}
