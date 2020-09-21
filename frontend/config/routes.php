<?php

return [
    '/' => 'site/index',
    'login' => 'site/login',
    'signup' => 'site/signup',
    'logout' => 'site/logout',
    
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