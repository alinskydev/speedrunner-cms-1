<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'OO5aqg8gPX4TYCFBukOp4B4wD7lMNhMv',
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['speedrunner'] = 'backend\modules\Speedrunner\Module';
}

return $config;
