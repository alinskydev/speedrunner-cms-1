<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;


class AuthController extends Controller
{
    static $forms = [
        'login' => '\common\forms\LoginForm',
        'signup' => '\frontend\forms\SignupForm',
        'request-password-reset' => '\frontend\forms\PasswordResetRequestForm',
    ];
    
    public function behaviors()
    {
        return [
            'format' => [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formatParam' => 'format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'text/xml' => Response::FORMAT_XML,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'login' => ['post'],
                    'signup' => ['post'],
                    'request-password-reset' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionLogin()
    {
        $model = new $this->forms['login'];
        $model->load(['LoginForm' => Yii::$app->request->post()]);
        
        if ($model->validate()) {
            if ($model->login()) {
                return [
                    'errors' => null,
                    'access-token' => Yii::$app->user->identity->auth_key
                ];
            } else {
                return ['errors' => $model->errors];
            }
        } else {
            return ['errors' => $model->errors];
        }
    }
    
    public function actionSignup()
    {
        $model = new $this->forms['signup'];
        $model->load(['SignupForm' => Yii::$app->request->post()]);
        
        if ($model->validate()) {
            if ($user = $model->signup()) {
                return [
                    'errors' => null,
                    'access-token' => $user->auth_key
                ];
            } else {
                return ['errors' => $model->errors];
            }
        } else {
            return ['errors' => $model->errors];
        }
    }
    
    public function actionRequestPasswordReset()
    {
        $model = new $this->forms['reset-password'];
        $model->load(['PasswordResetRequestForm' => Yii::$app->request->post()]);
        
        if ($model->validate()) {
            $model->sendEmail();
            return ['errors' => null];
        } else {
            return ['errors' => $model->errors];
        }
    }
}
