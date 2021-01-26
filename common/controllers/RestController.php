<?php

namespace common\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use yii\web\Response;


class RestController extends Controller
{
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
}
