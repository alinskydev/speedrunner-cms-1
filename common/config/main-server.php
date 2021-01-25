<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=sr-cms',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'schemaCache' => 'cache',
            'schemaCacheDuration' => 84000,
            'enableSchemaCache' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'yii\caching\FileCache',
        ],
    ],
];
