<?php

namespace api\controllers;

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
                    'file-delete' => ['post'],
                ],
            ],
        ]);
    }
    
    public function actions()
    {
        return [
            'index' => Actions\rest\DataProviderAction::className(),
            'view' => Actions\rest\ViewAction::className(),
            'create' => [
                'class' => Actions\rest\CreateAction::className(),
                'model_files' => ['images'],
            ],
            'update' => [
                'class' => Actions\rest\UpdateAction::className(),
                'model_files' => ['images'],
            ],
            'delete' => Actions\rest\DeleteAction::className(),
            'file-delete' => [
                'class' => Actions\rest\FileDeleteAction::className(),
                'allowed_attributes' => ['images'],
            ],
        ];
    }
}
