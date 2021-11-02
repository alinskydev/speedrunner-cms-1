<?php

namespace api\modules\v1\controllers;

use Yii;
use speedrunner\controllers\RestController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\Blog;


class BlogController extends RestController
{
    public function init()
    {
        $this->model = new Blog();
        return parent::init();
    }
    
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'view' => ['get'],
                    'create' => ['post'],
                    'update' => ['post'],
                    'delete' => ['post'],
                ],
            ],
        ]);
    }
    
    public function actions()
    {
        return [
            'index' => Actions\rest\DataProviderAction::className(),
            'view' => Actions\rest\ViewAction::className(),
            'create' => Actions\rest\CreateAction::className(),
            'update' => Actions\rest\UpdateAction::className(),
            'delete' => Actions\rest\DeleteAction::className(),
        ];
    }
}
