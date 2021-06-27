<?php

namespace backend\modules\User\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\User\models\UserRole;


class RoleController extends CrudController
{
    public function init()
    {
        $this->model = new UserRole();
        return parent::init();
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
    }
    
    public function findModel($id)
    {
        return $this->model->find()
            ->andWhere([
                'and',
                ['id' => $id],
                ['!=', 'id', 1],
            ])
            ->one();
    }
}
