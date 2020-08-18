<?php

return [
    '/' => 'site/index',
    'login' => 'site/login',
    'signup' => 'site/signup',
    'logout' => 'site/logout',
    
    'contact' => 'site/contact',
    
    'blog' => 'blog/index',
    'blog/<url>' => 'blog/view',
    
    'page/<url>' => 'block/view',
    
    'order/view/<key>' => 'order/view',
    
    'product/catalog' => [
        'class' => 'frontend\components\ProductCategoryUrlRule',
        'route' => 'product/catalog'
    ],
];