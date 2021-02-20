<?php

namespace backend\modules\Banner\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Banner\models\Banner;


class BannerController extends CrudController
{
    public function init()
    {
        $this->model = new Banner();
        return parent::init();
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'update']);
    }
    
    public function findModel($id)
    {
        return $this->model->find()->with(['groups'])->andWhere(['id' => $id])->one();
    }
}
