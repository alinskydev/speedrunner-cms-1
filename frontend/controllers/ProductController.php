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
        
        $possible_cats = ProductCategory::find()
            ->andWhere([
                'and',
                ['slug' => $slug],
                ['>', 'depth', 0],
            ])
            ->all();
        
        foreach ($possible_cats as $p_c) {
            if ($p_c->url() == $url) {
                $cat = $p_c;
            }
        }
        
        $cat = $cat ?? new ProductCategory();
        
        return $this->render('catalog', [
            'cat' => $cat,
            'parent_cats' => $cat->parents()->andWhere(['>', 'depth', 0])->all(),
        ]);
    }
}
