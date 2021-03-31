<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use speedrunner\actions as Actions;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\forms\LoginForm;
use frontend\forms\ResetPasswordRequestForm;
use frontend\forms\ResetPasswordForm;
use frontend\forms\SignupForm;


class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'reset-password-request', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['signup', 'reset-password-request', 'reset-password'],
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
    
    public function actions()
    {
        return [
            'signup' => [
                'class' => Actions\web\FormAction::className(),
                'model_class' => SignupForm::className(),
                'render_view' => 'signup',
                'run_method' => 'signup',
                'success_message' => 'signup_success_alert',
                'redirect_route' => ['site/index'],
            ],
            'reset-password-request' => [
                'class' => Actions\web\FormAction::className(),
                'model_class' => ResetPasswordRequestForm::className(),
                'render_view' => 'reset_password_request',
                'run_method' => 'sendEmail',
                'success_message' => 'reset_password_request_success_alert',
                'redirect_route' => ['site/index'],
            ],
            'reset-password' => [
                'class' => Actions\web\FormAction::className(),
                'model_class' => ResetPasswordForm::className(),
                'model_params' => ['token' => Yii::$app->request->get('token')],
                'render_view' => 'reset_password',
                'run_method' => 'resetPassword',
                'success_message' => 'reset_password_success_alert',
                'redirect_route' => ['site/index'],
            ],
        ];
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
}
