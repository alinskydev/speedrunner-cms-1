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
                'model' => new Blog(),
                'attribute' => 'name',
                'type' => 'translation',
            ],
            'blog-categories' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model' => new BlogCategory(),
                'attribute' => 'name',
                'type' => 'translation',
            ],
            'blog-tags' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model' => new BlogTag(),
                'attribute' => 'name',
                'type' => 'self',
            ],
            'products' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model' => new Product(),
                'attribute' => 'name',
                'type' => 'translation',
                'filter' => ['!=', 'id', Yii::$app->request->get('id')],
            ],
            'product-brands' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model' => new ProductBrand(),
                'attribute' => 'name',
                'type' => 'translation',
            ],
            'product-specifications' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model' => new ProductSpecification(),
                'attribute' => 'name',
                'type' => 'translation',
            ],
            'users' => [
                'class' => Actions\web\ItemsListAction::className(),
                'model' => new User(),
                'attribute' => 'username',
                'type' => 'self',
                'filter' => ['User.role' => Yii::$app->request->get('role')],
            ],
        ];
    }
}
