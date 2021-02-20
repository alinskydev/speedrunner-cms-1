<?php

namespace speedrunner\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use speedrunner\actions as Actions;
use speedrunner\db\ActiveRecord;


class CrudController extends Controller
{
    public ActiveRecord $model;
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\crud\DataProviderAction::className(),
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
    
    public function findModel($id)
    {
        return $this->model->findOne($id);
    }
}
