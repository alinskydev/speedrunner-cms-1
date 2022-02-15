<?php

return [
    '<controller>/view' => [
        'pattern' => '<controller>/view/<id>',
        'route' => '<controller>/view',
        'defaults' => ['id' => 0],
    ],
    '<controller>/update' => [
        'pattern' => '<controller>/update/<id>',
        'route' => '<controller>/update',
        'defaults' => ['id' => 0],
    ],
    '<controller>/delete' => [
        'pattern' => '<controller>/delete/<id>',
        'route' => '<controller>/delete',
        'defaults' => ['id' => 0],
    ],
    '<controller>/file-delete' => [
        'pattern' => '<controller>/file-delete/<id>',
        'route' => '<controller>/file-delete',
        'defaults' => ['id' => 0],
    ],

    'staticpage/<name>' => 'staticpage/view',
];
