<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;


class AuthController extends Controller
{
    protected $forms = [
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
        $model->load([$model->formName() => Yii::$app->request->post()]);
        
        if ($model->validate()) {
            $model->login();
            
            return [
                'name' => 'OK',
                'message' => [
                    'access_token' => Yii::$app->user->identity->auth_key,
                ],
                'code' => 0,
                'status' => 200,
            ];
        } else {
            Yii::$app->response->statusCode = 422;
            
            return [
                'name' => 'Unprocessable entity',
                'message' => $model->errors,
                'code' => 0,
                'status' => 422,
                'type' => 'yii\\web\\UnprocessableEntityHttpException',
            ];
        }
    }
    
    public function actionSignup()
    {
        $model = new $this->forms['signup'];
        $model->load([$model->formName() => Yii::$app->request->post()]);
        
        if ($model->validate()) {
            $user = $model->signup();
            
            return [
                'name' => 'OK',
                'message' => [
                    'access_token' => $user->auth_key,
                ],
                'code' => 0,
                'status' => 200,
            ];
        } else {
            Yii::$app->response->statusCode = 422;
            
            return [
                'name' => 'Unprocessable entity',
                'message' => $model->errors,
                'code' => 0,
                'status' => 422,
                'type' => 'yii\\web\\UnprocessableEntityHttpException',
            ];
        }
    }
    
    public function actionRequestPasswordReset()
    {
        $model = new $this->forms['reset-password'];
        $model->load([$model->formName() => Yii::$app->request->post()]);
        
        if ($model->validate()) {
            $model->sendEmail();
            
            return [
                'name' => 'OK',
                'message' => 'Success',
                'code' => 0,
                'status' => 200,
            ];
        } else {
            Yii::$app->response->statusCode = 422;
            
            return [
                'name' => 'Unprocessable entity',
                'message' => $model->errors,
                'code' => 0,
                'status' => 422,
                'type' => 'yii\\web\\UnprocessableEntityHttpException',
            ];
        }
    }
}
