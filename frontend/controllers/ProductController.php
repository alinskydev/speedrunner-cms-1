<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use backend\modules\Product\models\ProductCategory;


class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'cache' => [
                'class' => 'yii\filters\PageCache',
                'enabled' => Yii::$app->settings->use_frontend_cache,
                'duration' => 0,
                'variations' => [
                    Yii::$app->language,
                    Yii::$app->user,
                    Yii::$app->request->get('full_url'),
                ],
            ],
        ];
    }
    
    public function actionCatalog($full_url)
    {
        $cat = ProductCategory::find()->with(['translation'])->where(['full_url' => $full_url])->one();
        
        return $this->render('catalog', [
            'cat' => $cat,
        ]);
    }
}
