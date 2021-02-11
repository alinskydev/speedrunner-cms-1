<?php

$app = explode('/', $_SERVER['SCRIPT_NAME'])[1] ?? null;

$config = [
    'timeZone' => 'UTC',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => ['i18n'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
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
                    'class' => 'common\framework\DbMessageSource',
                    'sourceMessageTable' => 'TranslationSource',
                    'messageTable' => 'TranslationMessage',
                ],
                'yii2*' => [
                    'class' => 'common\framework\DbMessageSource',
                    'sourceMessageTable' => 'TranslationSource',
                    'messageTable' => 'TranslationMessage',
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],

        //        URL managers

        'urlManager' => [
            'class' => 'common\framework\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $app ? require __DIR__ . "/../../$app/config/routes.php" : [],
        ],
        'urlManagerApi' => [
            'class' => 'common\framework\UrlManager',
            'baseUrl' => '/api',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/../../api/config/routes.php',
        ],
        'urlManagerBackend' => [
            'class' => 'common\framework\UrlManager',
            'baseUrl' => '/admin',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/../../backend/config/routes.php',
        ],
        'urlManagerFrontend' => [
            'class' => 'common\framework\UrlManager',
            'baseUrl' => '',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/../../frontend/config/routes.php',
        ],
        
        //        Services
        
        'services' => [
            'class' => 'common\bootstrap\Services',
            'services' => [
                'html' => 'common\services\HtmlService',
                'i18n' => 'common\services\I18NService',
                'image' => 'common\services\ImageService',
                'mail' => 'common\services\MailService',
                
                'settings' => 'backend\modules\System\services\SystemSettingsService',
                'staticpage' => 'backend\modules\Staticpage\services\StaticpageService',
            ],
        ],
    ],
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
}

return $config;
