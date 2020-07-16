<?php

return [
    '/' => 'site/index',
    'login' => 'site/login',
    'signup' => 'site/signup',
    'logout' => 'site/logout',
    
    'about' => 'site/about',
    'contact' => 'site/contact',
    
    'blog' => 'blog/index',
    'blog/<url>' => 'blog/view',
    
    'page/<url>' => 'block/view',
    
    'product/catalog' => [
        'class' => 'frontend\components\ProductCategoryUrlRule',
        'route' => 'product/catalog'
    ],
];