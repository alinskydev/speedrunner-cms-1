<?php

return [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'OO5aqg8gPX4TYCFBukOp4B4wD7lMNhMv',
        ],
    ],
    'bootstrap' => ['debug'],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1'],
        ],
    ],
];
