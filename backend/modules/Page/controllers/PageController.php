<?php

namespace backend\modules\Page\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Page\models\Page;
use backend\modules\Page\search\PageSearch;


class PageController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new Page();
        $this->modelSearch = new PageSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        $actions = ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
        
        return ArrayHelper::merge($actions, [
            'image-delete' => [
                'class' => Actions\crud\FileDeleteAction::className(),
                'allowed_attributes' => ['image'],
            ],
        ]);
    }
    
    public function findModel()
    {
        return Page::findOne(Yii::$app->request->get('id'));
    }
}
