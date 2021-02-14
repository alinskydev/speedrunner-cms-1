<?php

namespace backend\modules\Blog\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\BlogRate;
use backend\modules\Blog\search\BlogRateSearch;


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
