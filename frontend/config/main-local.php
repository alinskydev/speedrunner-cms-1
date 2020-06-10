<?php
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'KkYlBx33UD4_1j2utpYAEVmxSb3oXbRr',
        ],
    ],
    'bootstrap' => ['debug'],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            // uncomment and adjust the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            // uncomment and adjust the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1'],
        ],
    ],
];
