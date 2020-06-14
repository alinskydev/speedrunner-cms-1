<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\filters\VerbFilter;

use api\modules\v1\models\Blog;


class BlogController extends Controller
{
    public function behaviors()
    {
        return [
            'format' => [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formatParam' => 'format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'text/xml' => Response::FORMAT_XML,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'view' => ['get'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Blog::find(),
            'pagination' => [
                'pageSize' => 20
            ],
        ]);
    }
    
    public function actionView($id)
    {
        if ($model = Blog::findOne($id)) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }
}
