<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\services\DataService;

use common\forms\LoginForm;
use frontend\forms\RequestResetPasswordForm;
use frontend\forms\ResetPasswordForm;
use frontend\forms\SignupForm;
use frontend\forms\ContactForm;

use backend\modules\Blog\models\Blog;
use backend\modules\Product\models\ProductCategory;


class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'request-reset-password', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['signup', 'request-reset-password', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
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
        $categories = (new DataService($categories_tree))->buildFullPath('slug');
        
        return $this->render('index', [
            'page' => $page['page'],
            'blocks' => $page['blocks'],
            'categories' => $categories,
        ]);
    }
    
    public function actionContact()
    {
        $model = new ContactForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('app', 'An error occured'));
            }
            
            return $this->refresh();
        }
        
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->login();
            return $this->goBack();
        } else {
            $model->password = null;
        }
        
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
    
    public function actionSignup()
    {
        $model = new SignupForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->signup();
            Yii::$app->session->setFlash('success', Yii::t('app', 'You have been registered successfully'));
            return $this->goHome();
        }
        
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    
    public function actionRequestResetPassword()
    {
        $model = new RequestResetPasswordForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email inbox for further instructions'));
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('app', 'An error occured'));
            }
            
            return $this->goHome();
        }
        
        return $this->render('reset_password_request', [
            'model' => $model,
        ]);
    }
    
    public function actionResetPassword($token)
    {
        $model = new ResetPasswordForm($token);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->resetPassword();
            Yii::$app->session->setFlash('success', Yii::t('app', 'New password saved'));
            return $this->goHome();
        }
        
        return $this->render('reset_password', [
            'model' => $model,
        ]);
    }
}
