<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use speedrunner\actions as Actions;
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
    public function actions()
    {
        return [
            'blogs' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model_class' => Blog::className(),
                'attribute' => 'name',
                'type' => 'translation',
            ],
            'blog-categories' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model_class' => BlogCategory::className(),
                'attribute' => 'name',
                'type' => 'translation',
            ],
            'blog-tags' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model_class' => BlogTag::className(),
                'attribute' => 'name',
                'type' => 'self',
            ],
            'products' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model_class' => Product::className(),
                'attribute' => 'name',
                'type' => 'translation',
                'filter' => ['!=', 'id', Yii::$app->request->get('id')],
            ],
            'product-brands' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model_class' => ProductBrand::className(),
                'attribute' => 'name',
                'type' => 'self',
            ],
            'product-specifications' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model_class' => ProductSpecification::className(),
                'attribute' => 'name',
                'type' => 'translation',
            ],
            'users' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model_class' => User::className(),
                'attribute' => 'username',
                'type' => 'self',
                'filter' => ['User.role' => Yii::$app->request->get('role')],
            ],
        ];
    }
}
