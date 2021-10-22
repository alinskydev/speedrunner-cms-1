<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=sr-cms-1',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8mb4',
            'schemaCache' => 'cache',
            'schemaCacheDuration' => 84000,
            'enableSchemaCache' => true,
        ],
    ],
];
