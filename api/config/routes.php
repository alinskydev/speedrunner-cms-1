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
    
    '<module>/staticpage/<name>' => '<module>/staticpage/view',
    
    '<module>/<controller>/view/<id>' => '<module>/<controller>/view',
    '<module>/<controller>/update/<id>' => '<module>/<controller>/update',
    '<module>/<controller>/delete/<id>' => '<module>/<controller>/delete',
];