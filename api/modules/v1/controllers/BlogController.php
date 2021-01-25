<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use common\actions\rest\{IndexAction};

use backend\modules\Blog\modelsSearch\BlogSearch;


class BlogController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new BlogSearch(),
            ],
        ];
    }
}
