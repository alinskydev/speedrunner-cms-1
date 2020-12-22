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
        
        $possible_cats = ProductCategory::find()->andWhere(['slug' => $slug])->all();
        
        foreach ($possible_cats as $cat) {
            if ($cat->url() == $url) {
                return $this->render('catalog', [
                    'cat' => $cat,
                ]);
            }
        }
        
        return $this->redirect(Yii::$app->request->referrer);
    }
}
