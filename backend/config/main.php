<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'homeUrl' => '/admin',
    'modules' => [
        'banner' => ['class' => 'backend\modules\Banner\Module'],
        'block' => ['class' => 'backend\modules\Block\Module'],
        'blog' => ['class' => 'backend\modules\Blog\Module'],
        'gallery' => ['class' => 'backend\modules\Gallery\Module'],
        'menu' => ['class' => 'backend\modules\Menu\Module'],
        'page' => ['class' => 'backend\modules\Page\Module'],
        'product' => ['class' => 'backend\modules\Product\Module'],
        'seo' => ['class' => 'backend\modules\Seo\Module'],
        'speedrunner' => ['class' => 'backend\modules\Speedrunner\Module'],
        'static-page' => ['class' => 'backend\modules\StaticPage\Module'],
        'system' => ['class' => 'backend\modules\System\Module'],
        'user' => ['class' => 'backend\modules\User\Module'],
        'zzz' => ['class' => 'backend\modules\Zzz\Module'],
        
        'rbac' => ['class' => 'yii2mod\rbac\Module'],
    ],
    'as access' => [
       'class' => 'yii2mod\rbac\filters\AccessControl',
       'allowActions' => [
           'site/login',
           'site/logout',
       ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
        ],
        'user' => [
            'identityClass' => 'backend\modules\User\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
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
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        'js/bootstrap.min.js',
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'css' => [
                        'css/bootstrap.min.css',
                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
];
