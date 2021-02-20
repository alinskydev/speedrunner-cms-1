<?php

namespace backend\modules\Translation\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Translation\models\TranslationSource;


class SourceController extends CrudController
{
    public function init()
    {
        $this->model = new TranslationSource();
        return parent::init();
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'update']);
    }
    
    public function findModel($id)
    {
        return $this->model->find()->with(['translations'])->andWhere(['id' => $id])->one();
    }
}
