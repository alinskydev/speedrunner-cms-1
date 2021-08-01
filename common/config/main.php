<?php

$app = explode('/', $_SERVER['SCRIPT_NAME'])[1] ?? null;
$routes_file = __DIR__ . "/../../$app/config/routes.php";
$routes = $app && file_exists($routes_file) ? require $routes_file : [];

$params = require 'params.php';

return [
    'timeZone' => 'UTC',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => ['debug', 'i18n'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => $params['debug_ips'],
        ],
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
            'translations' => [
                'app*' => [
                    'class' => 'speedrunner\i18n\DbMessageSource',
                    'sourceMessageTable' => 'translation_source',
                    'messageTable' => 'translation_message',
                ],
                'yii2*' => [
                    'class' => 'speedrunner\i18n\DbMessageSource',
                    'sourceMessageTable' => 'translation_source',
                    'messageTable' => 'translation_message',
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        //        URL managers

        'urlManager' => [
            'class' => 'speedrunner\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $routes,
        ],
        'urlManagerApi' => [
            'class' => 'speedrunner\web\UrlManager',
            'baseUrl' => '/api',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/../../api/config/routes.php',
        ],
        'urlManagerBackend' => [
            'class' => 'speedrunner\web\UrlManager',
            'baseUrl' => '/admin',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/../../backend/config/routes.php',
        ],
        'urlManagerFrontend' => [
            'class' => 'speedrunner\web\UrlManager',
            'baseUrl' => '',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/../../frontend/config/routes.php',
        ],
        
        //        Components
        
        'helpers' => [
            'class' => 'speedrunner\bootstrap\Components',
            'components' => [
                'array' => 'speedrunner\helpers\ArrayHelper',
                'formatter' => 'speedrunner\helpers\FormatterHelper',
                'html' => 'speedrunner\helpers\HtmlHelper',
                'image' => 'speedrunner\helpers\ImageHelper',
                'string' => 'speedrunner\helpers\StringHelper',
            ],
        ],
        'services' => [
            'class' => 'speedrunner\bootstrap\Components',
            'components' => [
                'cart' => 'speedrunner\services\CartService',
                'data' => 'speedrunner\services\DataService',
                'file' => 'speedrunner\services\FileService',
                'i18n' => 'speedrunner\services\I18NService',
                'mail' => 'speedrunner\services\MailService',
                
                'notification' => 'backend\modules\User\services\UserNotificationService',
                'settings' => 'backend\modules\System\services\SystemSettingsService',
                'staticpage' => 'backend\modules\Staticpage\services\StaticpageService',
            ],
        ],
    ],
];
