<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=sr-cms',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCache' => 'cache',
            'schemaCacheDuration' => 84000,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
