<?php

namespace backend\modules\Blog\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\BlogTag;
use backend\modules\Blog\modelsSearch\BlogTagSearch;


class TagController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new BlogTag();
        $this->modelSearch = new BlogTagSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
    }
    
    public function findModel()
    {
        return BlogTag::findOne(Yii::$app->request->get('id'));
    }
}
