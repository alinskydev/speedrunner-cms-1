<?php

namespace common\controllers;

use Yii;
use yii\web\Controller;
use common\actions as Actions;
use common\framework\ActiveRecord;


class CrudController extends Controller
{
    public ?ActiveRecord $model;
    public ?ActiveRecord $modelSearch;
    
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\crud\ListAction::className(),
            ],
            'view' => [
                'class' => Actions\crud\ViewAction::className(),
            ],
            'create' => [
                'class' => Actions\crud\CreateAction::className(),
            ],
            'update' => [
                'class' => Actions\crud\UpdateAction::className(),
            ],
            'delete' => [
                'class' => Actions\crud\DeleteAction::className(),
            ],
        ];
    }
}
