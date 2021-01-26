<?php

return [
    '/' => 'site/index',
    'login' => 'site/login',
    'signup' => 'site/signup',
    'logout' => 'site/logout',
    'request-reset-password' => 'site/request-reset-password',
    'reset-password' => 'site/reset-password',
    
    'contact' => 'site/contact',
    
    'blog' => 'blog/index',
    'blog/<slug>' => 'blog/view',
    
    'block-page/<slug>' => 'block/view',
    
    'order/view/<key>' => 'order/view',
    
    'product/catalog' => [
        'class' => 'frontend\components\NestedSetUrlRule',
        'route' => 'product/catalog',
        'path' => 'catalog',
    ],
];