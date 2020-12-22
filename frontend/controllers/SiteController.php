<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use common\forms\LoginForm;
use frontend\forms\ResetPasswordRequestForm;
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
                'only' => ['logout', 'signup', 'request-password-reset', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['signup', 'request-password-reset', 'reset-password'],
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
        $page = Yii::$app->sr->record->staticpage('home');
        
        return $this->render('index', [
            'page' => $page['page'],
            'blocks' => $page['blocks'],
            'categories' => ProductCategory::find()->all(),
        ]);
    }
    
    public function actionContact()
    {
        $model = new ContactForm;
        
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
        
        $model = new LoginForm;
        
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
        $model = new SignupForm;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->signup();
            Yii::$app->session->setFlash('success', Yii::t('app', 'You have been registered successfully'));
            
            return $this->goHome();
        }
        
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    
    public function actionResetPasswordRequest()
    {
        $model = new ResetPasswordRequestForm;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email inbox for further instructions'));
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('app', 'An error occured'));
            }
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
