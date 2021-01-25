<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'OO5aqg8gPX4TYCFBukOp4B4wD7lMNhMv',
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = 'yii\gii\Module';
    $config['modules']['rbac'] = 'yii2mod\rbac\Module';
    $config['modules']['speedrunner'] = 'backend\modules\Speedrunner\Module';
}

return $config;
