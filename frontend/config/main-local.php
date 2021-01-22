<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'KkYlBx33UD4_1j2utpYAEVmxSb3oXbRr',
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
}

return $config;
