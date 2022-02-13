<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'homeUrl' => '/api',
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'baseUrl' => '/api',
            'cookieValidationKey' => 'OO5aqg8gPX4TYCFBukOp4B4wD7lMNhMv',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser',
            ],
        ],
        'user' => [
            'identityClass' => 'backend\modules\User\models\User',
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 4 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@frontend/runtime/cache',
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON
        ],
    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\Cors',
        'cors' => [
            'Origin' => ['*'],
            'Access-Control-Request-Method' => ['GET', 'POST'],
        ],
    ],
    'params' => $params,
];
