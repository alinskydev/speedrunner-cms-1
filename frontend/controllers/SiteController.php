<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use frontend\forms\FeedbackForm;

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
                'model_class' => FeedbackForm::className(),
                'render_view' => 'contact',
                'run_method' => 'sendEmail',
                'success_message' => 'contact_success_alert',
                'redirect_route' => ['site/index'],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $page = Yii::$app->services->staticpage->home;
        
        $categories_tree = ProductCategory::find()->andWhere(['depth' => 0])->one()->setJsonAttributes(['name'])->tree();
        $categories = Yii::$app->helpers->array->buildFullPath($categories_tree, 'slug');
        
        return $this->render('index', [
            'page' => $page['page'],
            'blocks' => $page['blocks'],
            'categories' => $categories,
        ]);
    }
}
