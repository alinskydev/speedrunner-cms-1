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
        
        $possible_categories = ProductCategory::find()
            ->andWhere([
                'and',
                ['slug' => $slug],
                ['>', 'depth', 0],
            ])
            ->all();
        
        foreach ($possible_categories as $p_c) {
            if ($p_c->url() == $url) {
                $category = $p_c;
            }
        }
        
        $category = $category ?? new ProductCategory();
        
        return $this->render('catalog', [
            'category' => $category,
            'parent_categories' => $category->parents()->andWhere(['>', 'depth', 0])->all(),
        ]);
    }
}
