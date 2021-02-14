<?php

namespace backend\modules\User\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\User\models\User;
use backend\modules\User\search\UserSearch;


class UserController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new User();
        $this->modelSearch = new UserSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        $actions = ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
        
        return ArrayHelper::merge($actions, [
            'file-delete' => [
                'class' => Actions\crud\FileDeleteAction::className(),
                'allowed_attributes' => ['image'],
            ],
        ]);
    }
    
    public function findModel()
    {
        return User::findOne(Yii::$app->request->get('id'));
    }
}
