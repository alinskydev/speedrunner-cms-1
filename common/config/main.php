<?php

$app = explode('/', $_SERVER['SCRIPT_NAME'])[1];

return [
    'timeZone' => 'UTC',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => ['i18n', 'frontendLocalisedRoutes'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
    ],
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'UTC',
            'dateFormat' => 'php: d.m.Y',
            'datetimeFormat' => 'php: d.m.Y H:i',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
        ],
        'i18n' => [
            'class' => 'pavlinter\translation\I18N',
            'translations' => [
                '*' => [
                    'class' => 'pavlinter\translation\DbMessageSource',
                    'forceTranslation' => true,
                    'autoInsert' => true, //if message key doesn't exist in the database, message key will be created automatically
                    'dotMode' => 'show', //default state: show or hide dot
                ],
            ],
            'dialog' => 'bs', //Bootstrap Modal Or jQuery Dialog (bs or jq)
            'access' => 'admin',  //user permissions or function(){ return true || false; }
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
        ],

        //        URL MANAGERS

        'urlManager' => [
            'class' => 'common\components\framework\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $app ? require __DIR__ . "/../../$app/config/routes.php" : [],
        ],
        'urlManagerApi' => [
            'class' => 'common\components\framework\UrlManager',
            'baseUrl' => '/api',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/../../api/config/routes.php',
        ],
        'urlManagerBackend' => [
            'class' => 'common\components\framework\UrlManager',
            'baseUrl' => '/admin',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/../../backend/config/routes.php',
        ],
        'urlManagerFrontend' => [
            'class' => 'common\components\framework\UrlManager',
            'baseUrl' => '',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/../../frontend/config/routes.php',
        ],
        
        //        HELPERS
        
        'settings' => ['class' => 'common\components\Settings'],
        'sr' => ['class' => 'common\helpers\Speedrunner'],
        'frontendLocalisedRoutes' => ['class' => 'frontend\components\LocalisedRoutes'],
    ],
];
