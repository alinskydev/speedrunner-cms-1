<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use frontend\forms\ContactForm;

use backend\modules\Blog\models\Blog;
use backend\modules\Product\models\ProductCategory;


class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'contact' => [
                'class' => Actions\web\FormAction::className(),
                'model_class' => ContactForm::className(),
                'render_view' => 'contact',
                'run_method' => 'sendEmail',
                'success_message' => 'Thank you for contacting us. We will respond to you as soon as possible.',
                'redirect_route' => ['site/index'],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $page = Yii::$app->services->staticpage->home;
        
        $categories_tree = ProductCategory::find()->andWhere(['depth' => 0])->one()->setJsonAttributes(['name'])->tree();
        $categories = Yii::$app->services->array->buildFullPath($categories_tree, 'slug');
        
        return $this->render('index', [
            'page' => $page['page'],
            'blocks' => $page['blocks'],
            'categories' => $categories,
        ]);
    }
}
