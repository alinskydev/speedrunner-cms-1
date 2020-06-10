<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;


class FeedbackController extends Controller
{
    static $forms = [
        'send' => '\frontend\forms\ContactForm',
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
                    'send' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionSend()
    {
        $model = new $this->forms['send'];
        $model->load(['ContactForm' => Yii::$app->request->post()]);
        
        if ($model->validate()) {
            $model->send();
            return ['errors' => null];
        } else {
            return ['errors' => $model->errors];
        }
    }
}
