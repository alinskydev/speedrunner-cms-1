<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

use backend\modules\Blog\models\Blog;


class BlogController extends Controller
{
    public function behaviors()
    {
        return [
            'cache' => [
                'class' => 'yii\filters\PageCache',
                'duration' => 0,
                'only' => ['index', 'view'],
                'variations' => [
                    Yii::$app->language,
                    Yii::$app->user,
                    Yii::$app->request->get('page'),
                    Yii::$app->request->get('url'),
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $blogs = Blog::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $blogs,
            'pagination' => [
                'pageSize' => 1
            ],
        ]);
        
        return $this->render('index', [
            'blogs' => $dataProvider,
        ]);
    }
    
    public function actionView($url)
    {
        $model = Blog::find()->where([
            'and',
            ['url' => $url],
            ['<=', 'published', date('Y-m-d H:i:s')],
        ])->one();
        
        if (!$model) {
            return $this->redirect(['index']);
        }
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
