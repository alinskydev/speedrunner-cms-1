<?php

use yii\helpers\Html;
use yii\widgets\Menu;

$menuItems = [
    [
        'label' => Yii::t('app', 'Users'),
        'icon' => 'user',
        'items' => [
            ['label' => Yii::t('app', 'Users'), 'url' => ['/user/user']],
            ['label' => Yii::t('app', 'RBAC'), 'url' => ['/rbac/rbac']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Static pages'),
        'items' => [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/static-page/update/home']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Content'),
        'items' => [
            ['label' => Yii::t('app', 'Menu'), 'icon' => 'bars', 'url' => ['/menu/menu/tree']],
            ['label' => Yii::t('app', 'Pages'), 'url' => ['/page/page']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Blocks'),
        'items' => [
            ['label' => Yii::t('app', 'Types'), 'url' => ['/block/type']],
            ['label' => Yii::t('app', 'Pages'), 'url' => ['/block/page']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Blogs'),
        'items' => [
            ['label' => Yii::t('app', 'Blogs'), 'url' => ['/blog/blog']],
            ['label' => Yii::t('app', 'Categories'), 'url' => ['/blog/category']],
            ['label' => Yii::t('app', 'Tags'), 'url' => ['/blog/tag']],
            ['label' => Yii::t('app', 'Comments'), 'url' => ['/blog/comment']],
            ['label' => Yii::t('app', 'Rates'), 'url' => ['/blog/rate']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Products'),
        'items' => [
            ['label' => Yii::t('app', 'Products'), 'url' => ['/product/product']],
            ['label' => Yii::t('app', 'Categories'), 'url' => ['/product/category/tree']],
            ['label' => Yii::t('app', 'Brands'), 'url' => ['/product/brand']],
            ['label' => Yii::t('app', 'Attributes'), 'url' => ['/product/attribute']],
            ['label' => Yii::t('app', 'Comments'), 'url' => ['/product/comment']],
            ['label' => Yii::t('app', 'Rates'), 'url' => ['/product/rate']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Media'),
        'items' => [
            ['label' => Yii::t('app', 'Banners'), 'url' => ['/banner/banner']],
            ['label' => Yii::t('app', 'Gallery'), 'url' => ['/gallery/gallery']],
        ],
    ],
    
    [
        'label' => Yii::t('app', 'System'),
        'items' => [
            ['label' => Yii::t('app', 'Settings'),'url' => ['/system/settings/update']],
            ['label' => Yii::t('app', 'Languages'), 'url' => ['/system/language']],
            ['label' => Yii::t('app', 'Translations'), 'url' => ['/system/translation-source']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Cache'),
        'items' => [
            ['label' => Yii::t('app', 'Refresh routes'), 'url' => ['/cache/refresh-routes']],
            ['label' => Yii::t('app', 'Remove thumbs'), 'url' => ['/cache/remove-thumbs']],
            ['label' => Yii::t('app', 'Clear'), 'url' => ['/cache/clear']],
        ],
    ],
    [
        'label' => Yii::t('app', 'SpeedRunner'),
        'items' => [
            ['label' => Yii::t('app', 'Information'), 'url' => ['/speedrunner/information/']],
            ['label' => Yii::t('app', 'Functions'), 'url' => ['/speedrunner/speedrunner']],
        ],
    ],
];

echo Menu::widget([
    'items' => $menuItems,
    'options' => ['class' => 'nav-items'],
    'labelTemplate' => '<div class="parent">{label}</div>',
    'submenuTemplate' => '<ul class="items">{items}</ul>',
    'encodeLabels' => false,
    'activateParents' => true,
]);

?>
