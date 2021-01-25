<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\Blog;
use backend\modules\Blog\models\BlogCategory;
use backend\modules\Blog\models\BlogTag;
use backend\modules\Product\models\Product;
use backend\modules\Product\models\ProductBrand;
use backend\modules\Product\models\ProductSpecification;
use backend\modules\User\models\User;


class ItemsListController extends Controller
{
    public function actionBlogs($q = null)
    {
        $out['results'] = Blog::find()->itemsList('name', 'translation', $q)->asArray()->all();
        return $this->asJson($out);
    }
    
    public function actionBlogCategories($q = null)
    {
        $out['results'] = BlogCategory::find()->itemsList('name', 'translation', $q)->asArray()->all();
        return $this->asJson($out);
    }
    
    public function actionBlogTags($q = null)
    {
        $out['results'] = BlogTag::find()->itemsList('name', 'self', $q)->asArray()->all();
        return $this->asJson($out);
    }
    
    public function actionProducts($q = null, $id = null)
    {
        $out['results'] = Product::find()->itemsList('name', 'translation', $q)->andFilterWhere(['!=', 'id', $id])->asArray()->all();
        return $this->asJson($out);
    }
    
    public function actionProductBrands($q = null)
    {
        $out['results'] = ProductBrand::find()->itemsList('name', 'translation', $q)->asArray()->all();
        return $this->asJson($out);
    }
    
    public function actionProductSpecifications($q = null)
    {
        $out['results'] = ProductSpecification::find()->itemsList('name', 'translation', $q)->asArray()->all();
        return $this->asJson($out);
    }
    
    public function actionUsers($q = null, $role = null)
    {
        $out['results'] = User::find()->itemsList('username', 'self', $q)->andFilterWhere(['User.role' => $role])->asArray()->all();
        return $this->asJson($out);
    }
}
