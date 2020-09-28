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
                    Yii::$app->request->get(),
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $blogs = Blog::find()->orderBy('published DESC');
        
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
    
    public function actionView($slug)
    {
        $model = Blog::find()->andWhere([
            'and',
            ['slug' => $slug],
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
