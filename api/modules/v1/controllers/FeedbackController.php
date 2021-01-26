<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use common\controllers\RestController as Controller;
use common\actions\rest as Actions;


class FeedbackController extends Controller
{
    const FORMS = [
        'send' => '\frontend\forms\ContactForm',
    ];
    
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'send' => ['post'],
                ],
            ],
        ]);
    }
    
    public function actions()
    {
        return [
            'send' => [
                'class' => Actions\FormAction::className(),
                'run_method' => 'sendEmail',
            ],
        ];
    }
}
