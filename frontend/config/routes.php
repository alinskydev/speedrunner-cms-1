<?php

return [
    'login' => 'auth/login',
    'signup' => 'auth/signup',
    'logout' => 'auth/logout',
    'request-reset-password' => 'auth/request-reset-password',
    'reset-password/<token>' => 'auth/reset-password',
    
    '/' => 'site/index',
    'contact' => 'site/contact',
    
    'blog' => 'blog/index',
    'blog/<slug>' => 'blog/view',
    
    'block-page/<slug>' => 'block/view',
    
    'cart' => 'cart/index',
    'order/view/<key>' => 'order/view',
    
    'product/catalog' => [
        'class' => 'frontend\components\NestedSetUrlRule',
        'route' => 'product/catalog',
        'path' => 'catalog',
    ],
];