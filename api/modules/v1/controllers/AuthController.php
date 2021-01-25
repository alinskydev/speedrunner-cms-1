<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use common\actions\rest\{FormAction};


class AuthController extends Controller
{
    const FORMS = [
        'login' => '\common\forms\LoginForm',
        'signup' => '\frontend\forms\SignupForm',
        'request-password-reset' => '\frontend\forms\ResetPasswordRequestForm',
    ];
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'login' => ['post'],
                    'signup' => ['post'],
                    'request-password-reset' => ['post'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'login' => [
                'class' => FormAction::className(),
                'run_method' => 'login',
            ],
            'signup' => [
                'class' => FormAction::className(),
                'run_method' => 'signup',
            ],
            'request-password-reset' => [
                'class' => FormAction::className(),
                'run_method' => 'sendEmail',
            ],
        ];
    }
}
