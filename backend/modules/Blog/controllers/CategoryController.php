<?php

namespace backend\modules\Blog\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\BlogCategory;
use backend\modules\Blog\modelsSearch\BlogCategorySearch;


class CategoryController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new BlogCategory();
        $this->modelSearch = new BlogCategorySearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
    }
    
    public function findModel()
    {
        return BlogCategory::findOne(Yii::$app->request->get('id'));
    }
}
