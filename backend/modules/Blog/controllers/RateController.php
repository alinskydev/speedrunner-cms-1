<?php

namespace backend\modules\Blog\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\BlogRate;
use backend\modules\Blog\modelsSearch\BlogRateSearch;


class RateController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new BlogRate();
        $this->modelSearch = new BlogRateSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'delete']);
    }
}
