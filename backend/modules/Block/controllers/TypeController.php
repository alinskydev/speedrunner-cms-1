<?php

namespace backend\modules\Block\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Block\models\BlockType;
use backend\modules\Block\search\BlockTypeSearch;


class TypeController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new BlockType();
        $this->modelSearch = new BlockTypeSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'update']);
    }
    
    public function findModel()
    {
        return BlockType::findOne(Yii::$app->request->get('id'));
    }
}
