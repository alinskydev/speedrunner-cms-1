<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;
use speedrunner\services\ArrayService;

use frontend\forms\ContactForm;

use backend\modules\Blog\models\Blog;
use backend\modules\Product\models\ProductCategory;


class SiteController extends Controller
{
    public function actions()
    {
        return [
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
    
    public function actionError()
    {
        return $this->render('error', [
            'exception' => Yii::$app->errorHandler->exception
        ]);
    }
    
    public function actionIndex()
    {
        $page = Yii::$app->services->staticpage->home;
        
        $categories_tree = ProductCategory::find()->andWhere(['depth' => 0])->one()->setJsonAttributes(['name'])->tree();
        $categories = (new ArrayService($categories_tree))->buildFullPath('slug');
        
        return $this->render('index', [
            'page' => $page['page'],
            'blocks' => $page['blocks'],
            'categories' => $categories,
        ]);
    }
}
