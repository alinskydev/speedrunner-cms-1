<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use common\controllers\RestController as Controller;
use common\actions\rest as Actions;


class AuthController extends Controller
{
    const FORMS = [
        'login' => '\common\forms\LoginForm',
        'signup' => '\frontend\forms\SignupForm',
        'request-reset-password' => '\frontend\forms\RequestResetPasswordForm',
    ];
    
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => \yii\filters\auth\HttpBasicAuth::className(),
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'login' => ['post'],
                    'signup' => ['post'],
                    'request-reset-password' => ['post'],
                ],
            ],
        ]);
    }
    
    public function actions()
    {
        return [
            'login' => [
                'class' => Actions\FormAction::className(),
                'run_method' => 'login',
            ],
            'signup' => [
                'class' => Actions\FormAction::className(),
                'run_method' => 'signup',
            ],
            'request-reset-password' => [
                'class' => Actions\FormAction::className(),
                'run_method' => 'sendEmail',
            ],
        ];
    }
}
