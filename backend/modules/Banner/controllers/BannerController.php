<?php

namespace backend\modules\Banner\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Banner\models\Banner;
use backend\modules\Banner\modelsSearch\BannerSearch;


class BannerController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new Banner();
        $this->modelSearch = new BannerSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'update']);
    }
    
    public function findModel()
    {
        return Banner::find()->with(['groups'])->andWhere(['id' => Yii::$app->request->get('id')])->one();
    }
}
