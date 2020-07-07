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
        $cat = ProductCategory::find()->where(['full_url' => $full_url])->one();
        
        return $this->render('catalog', [
            'cat' => $cat,
        ]);
    }
}
