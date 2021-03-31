<?php

namespace api\modules\v1\controllers;

use Yii;
use speedrunner\controllers\RestController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use common\forms\LoginForm;
use frontend\forms\SignupForm;
use frontend\forms\ResetPasswordRequestForm;


class AuthController extends RestController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'login' => ['post'],
                    'signup' => ['post'],
                    'reset-password-request' => ['post'],
                ],
            ],
        ]);
    }
    
    public function actions()
    {
        return [
            'login' => [
                'class' => Actions\rest\FormAction::className(),
                'model_class' => LoginForm::className(),
                'run_method' => 'login',
            ],
            'signup' => [
                'class' => Actions\rest\FormAction::className(),
                'model_class' => SignupForm::className(),
                'run_method' => 'signup',
            ],
            'reset-password-request' => [
                'class' => Actions\rest\FormAction::className(),
                'model_class' => ResetPasswordRequestForm::className(),
                'run_method' => 'sendEmail',
            ],
        ];
    }
}
