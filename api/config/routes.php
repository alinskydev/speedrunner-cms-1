<?php

return [
//    'rest' => [
//        'class' => 'yii\rest\UrlRule',
//        'controller' => [
//            '',
//        ],
//        'only' => ['index', 'view'],
//        'pluralize' => false,
//    ],
    
    '<module>/banner/<id>' => '<module>/banner/view',
    '<module>/blog/<id>' => '<module>/blog/view',
    '<module>/language/<id>' => '<module>/language/view',
    '<module>/settings/<id>' => '<module>/settings/view',
    '<module>/static-page/<id>' => '<module>/static-page/view',
];