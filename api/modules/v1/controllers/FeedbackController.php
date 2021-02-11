<?php

namespace api\modules\v1\controllers;

use Yii;
use common\controllers\RestController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use frontend\forms\ContactForm;


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
                'model' => new ContactForm(),
                'run_method' => 'sendEmail',
            ],
        ];
    }
}
