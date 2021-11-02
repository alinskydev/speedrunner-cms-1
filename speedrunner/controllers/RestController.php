<?php

namespace speedrunner\controllers;

use Yii;
use yii\rest\Controller;
use speedrunner\db\ActiveRecord;
use yii\filters\ContentNegotiator;
use yii\web\Response;


class RestController extends Controller
{
    public ?ActiveRecord $model = null;
    
    public function behaviors()
    {
        return [
            'format' => [
                'class' => ContentNegotiator::className(),
                'formatParam' => 'format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'text/xml' => Response::FORMAT_XML,
                ],
            ],
        ];
    }
    
    public function findModel($id)
    {
        return $this->model ? $this->model->findOne($id) : null;
    }
}
