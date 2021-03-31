<?php

namespace api\modules\v1\controllers;

use Yii;
use speedrunner\controllers\RestController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use frontend\forms\FeedbackForm;


class FeedbackController extends RestController
{
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
                'class' => Actions\rest\FormAction::className(),
                'model_class' => FeedbackForm::className(),
                'run_method' => 'sendEmail',
            ],
        ];
    }
}
