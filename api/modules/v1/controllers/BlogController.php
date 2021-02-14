<?php

namespace api\modules\v1\controllers;

use Yii;
use common\controllers\RestController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\search\BlogSearch;


class BlogController extends RestController
{
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
            'index' => [
                'class' => Actions\rest\ListAction::className(),
                'modelSearch' => new BlogSearch(),
            ],
        ];
    }
}
