<?php

namespace backend\modules\Translation\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\Translation\forms\TranslationImportForm;
use backend\modules\Translation\forms\TranslationExportForm;

use backend\modules\Translation\models\TranslationSource;
use backend\modules\Translation\models\TranslationMessage;


class SourceController extends CrudController
{
    public function init()
    {
        $this->model = new TranslationSource();
        return parent::init();
    }
    
    public function actions()
    {
        $actions = ArrayHelper::filter(parent::actions(), ['index', 'update']);
        
        return ArrayHelper::merge($actions, [
            'import' => [
                'class' => Actions\web\FormAction::className(),
                'model_class' => TranslationImportForm::className(),
                'render_view' => 'import',
                'run_method' => 'import',
                'success_message' => 'Successfully imported',
                'redirect_route' => Yii::$app->request->referrer,
            ],
            'export' => [
                'class' => Actions\web\FormAction::className(),
                'model_class' => TranslationExportForm::className(),
                'render_view' => 'export',
                'run_method' => 'export',
            ],
        ]);
    }
    
    public function findModel($id)
    {
        return $this->model->find()->with(['translations'])->andWhere(['id' => $id])->one();
    }
}
