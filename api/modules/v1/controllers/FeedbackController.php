<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;


class FeedbackController extends Controller
{
    protected $forms = [
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
