<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'homeUrl' => '/admin',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'banner' => ['class' => 'backend\modules\Banner\Module'],
        'block' => ['class' => 'backend\modules\Block\Module'],
        'blog' => ['class' => 'backend\modules\Blog\Module'],
        'log' => ['class' => 'backend\modules\Log\Module'],
        'menu' => ['class' => 'backend\modules\Menu\Module'],
        'order' => ['class' => 'backend\modules\Order\Module'],
        'page' => ['class' => 'backend\modules\Page\Module'],
        'product' => ['class' => 'backend\modules\Product\Module'],
        'seo' => ['class' => 'backend\modules\Seo\Module'],
        'staticpage' => ['class' => 'backend\modules\Staticpage\Module'],
        'system' => ['class' => 'backend\modules\System\Module'],
        'translation' => ['class' => 'backend\modules\Translation\Module'],
        'user' => ['class' => 'backend\modules\User\Module'],
    ],
    'as access' => [
       'class' => 'yii2mod\rbac\filters\AccessControl',
       'allowActions' => [
           'auth/login',
           'auth/logout',
       ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
        ],
        'user' => [
            'identityClass' => 'backend\modules\User\models\User',
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['auth/login'],
            'enableAutoLogin' => true,
        ],
        'session' => [
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => []
                ],
            ],
        ],
    ],
    'params' => $params,
];
