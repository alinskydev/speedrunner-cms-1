<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use common\actions\rest\{FormAction};


class FeedbackController extends Controller
{
    const FORMS = [
        'send' => '\frontend\forms\ContactForm',
    ];
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'send' => ['post'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'send' => [
                'class' => FormAction::className(),
                'run_method' => 'sendEmail',
            ],
        ];
    }
}
