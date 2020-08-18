<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

use backend\modules\Product\models\ProductCategory;


class ProductController extends Controller
{
    public function actionCatalog($full_url)
    {
        $url = explode('/', $full_url);
        $url = end($url);
        
        if (!($cat = ProductCategory::find()->where(['url' => $url])->one())) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if ($cat->fullUrl() != $full_url) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        return $this->render('catalog', [
            'cat' => $cat,
        ]);
    }
}
