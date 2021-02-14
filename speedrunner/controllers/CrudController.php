<?php

namespace speedrunner\controllers;

use Yii;
use yii\web\Controller;
use speedrunner\actions as Actions;
use speedrunner\db\ActiveRecord;


class CrudController extends Controller
{
    public ?ActiveRecord $model;
    public ?ActiveRecord $modelSearch;
    
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
}
