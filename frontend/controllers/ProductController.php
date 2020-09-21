<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

use backend\modules\Product\models\ProductCategory;


class ProductController extends Controller
{
    public function actionCatalog($url)
    {
        $slug = explode('/', $url);
        $slug = end($slug);
        
        if (!($cat = ProductCategory::find()->where(['slug' => $slug])->one())) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if ($cat->url() != $url) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        return $this->render('catalog', [
            'cat' => $cat,
        ]);
    }
}
