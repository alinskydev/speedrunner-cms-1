<?php

return [
    '/' => 'site/index',
    'login' => 'site/login',
    'signup' => 'site/signup',
    'logout' => 'site/logout',
    'reset-password-request' => 'site/reset-password-request',
    'reset-password' => 'site/reset-password',
    
    'contact' => 'site/contact',
    
    'blog' => 'blog/index',
    'blog/<slug>' => 'blog/view',
    
    'page/<slug>' => 'block/view',
    
    'order/view/<key>' => 'order/view',
    
    'product/catalog' => [
        'class' => 'frontend\components\ProductCategoryUrlRule',
        'route' => 'product/catalog'
    ],
];