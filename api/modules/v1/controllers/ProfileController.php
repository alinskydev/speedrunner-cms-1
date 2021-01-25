<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use common\actions\rest\{FormAction};

use backend\modules\User\models\User;


class ProfileController extends Controller
{
    const FORMS = [
        'update' => '\frontend\forms\ProfileForm',
    ];
    
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => \yii\filters\auth\HttpBasicAuth::className(),
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'update' => ['post'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'update' => [
                'class' => FormAction::className(),
                'run_method' => 'update',
                'file_attributes' => ['image'],
            ],
        ];
    }
    
    public function actionIndex()
    {
        return Yii::$app->user->identity;
    }
}
