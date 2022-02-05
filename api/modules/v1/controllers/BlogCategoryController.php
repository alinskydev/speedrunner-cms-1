<?php

namespace api\modules\v1\controllers;

use Yii;
use speedrunner\controllers\RestController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\BlogCategory;


class BlogCategoryController extends RestController
{
    public function init()
    {
        $this->model = new BlogCategory();
        return parent::init();
    }
    
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ]);
    }
    
    public function actions()
    {
        return [
            'index' => Actions\rest\DataProviderAction::className(),
        ];
    }
}
