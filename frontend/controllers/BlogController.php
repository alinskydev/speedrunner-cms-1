<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

use backend\modules\Blog\models\Blog;


class BlogController extends Controller
{
    public function actionIndex()
    {
        $query = Blog::find()->published()->orderBy('published_at DESC');
        
        $blogs = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1
            ],
        ]);
        
        return $this->render('index', [
            'blogs' => $blogs,
        ]);
    }
    
    public function actionView($slug)
    {
        if (!($model = Blog::find()->bySlug($slug)->published()->one())) {
            return $this->redirect(['index']);
        }
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
