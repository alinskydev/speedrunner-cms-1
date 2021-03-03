<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\modules\Staticpage\models\Staticpage;

return [
    [
        'label' => Yii::t('app', 'Users'),
        'icon' => Html::tag('i', null, ['class' => 'fas fa-user']),
        'items' => [
            ['label' => Yii::t('app', 'Users'), 'url' => ['/user/user/index']],
            ['label' => Yii::t('app', 'RBAC'), 'url' => ['/rbac/rbac/index'], 'visible' => YII_ENV_DEV],
        ],
    ],
    [
        'label' => Yii::t('app', 'Static pages'),
        'icon' => Html::tag('i', null, ['class' => 'fas fa-file-alt']),
        'items' => ArrayHelper::getColumn(Staticpage::find()->asArray()->all(), function($value) {
            return ['label' => $value['label'], 'url' => ['/staticpage/staticpage/update', 'name' => $value['name']]];
        }),
    ],
    [
        'label' => Yii::t('app', 'Content'),
        'icon' => Html::tag('i', null, ['class' => 'fas fa-server']),
        'items' => [
            ['label' => Yii::t('app', 'Menu'), 'url' => ['/menu/menu/tree']],
            ['label' => Yii::t('app', 'Pages'), 'url' => ['/page/page/index']],
            ['label' => Yii::t('app', 'Banners'), 'url' => ['/banner/banner/index']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Blocks'),
        'icon' => Html::tag('i', null, ['class' => 'fas fa-th']),
        'items' => [
            ['label' => Yii::t('app', 'Types'), 'url' => ['/block/type/index']],
            ['label' => Yii::t('app', 'Pages'), 'url' => ['/block/page/index']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Blogs'),
        'icon' => Html::tag('i', null, ['class' => 'fas fa-newspaper']),
        'items' => [
            ['label' => Yii::t('app', 'Blogs'), 'url' => ['/blog/blog/index']],
            ['label' => Yii::t('app', 'Categories'), 'url' => ['/blog/category/index']],
            ['label' => Yii::t('app', 'Tags'), 'url' => ['/blog/tag/index']],
            ['label' => Yii::t('app', 'Comments'), 'url' => ['/blog/comment/index']],
            ['label' => Yii::t('app', 'Rates'), 'url' => ['/blog/rate/index']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Products'),
        'icon' => Html::tag('i', null, ['class' => 'fas fa-boxes']),
        'items' => [
            ['label' => Yii::t('app', 'Products'), 'url' => ['/product/product/index']],
            ['label' => Yii::t('app', 'Categories'), 'url' => ['/product/category/tree']],
            ['label' => Yii::t('app', 'Brands'), 'url' => ['/product/brand/index']],
            ['label' => Yii::t('app', 'Specifications'), 'url' => ['/product/specification/index']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Orders'),
        'icon' => Html::tag('i', null, ['class' => 'fas fa-shopping-cart']),
        'items' => [
            ['label' => Yii::t('app', 'Orders'), 'url' => ['/order/order/index']],
        ],
    ],
    
    [
        'label' => Yii::t('app', 'System'),
        'icon' => Html::tag('i', null, ['class' => 'fas fa-cogs']),
        'items' => [
            ['label' => Yii::t('app', 'Settings'),'url' => ['/system/settings/update']],
            ['label' => Yii::t('app', 'Languages'), 'url' => ['/system/language/index']],
            ['label' => Yii::t('app', 'Translations'), 'url' => ['/translation/source/index']],
            ['label' => Yii::t('app', 'Log actions'), 'url' => ['/log/action/index']],
        ],
    ],
    [
        'label' => Yii::t('app', 'SEO'),
        'icon' => Html::tag('i', null, ['class' => 'fab fa-searchengin']),
        'items' => [
            ['label' => Yii::t('app', 'Meta'),'url' => ['/seo/meta/update']],
            ['label' => Yii::t('app', 'Files'),'url' => ['/seo/file/update']],
        ],
    ],
    [
        'label' => Yii::t('app', 'Cache'),
        'icon' => Html::tag('i', null, ['class' => 'fas fa-trash-alt']),
        'items' => [
            ['label' => Yii::t('app', 'Remove thumbs'), 'url' => ['/cache/remove-thumbs']],
            ['label' => Yii::t('app', 'Clear'), 'url' => ['/cache/clear']],
        ],
    ],
    [
        'label' => 'Speedrunner',
        'icon' => Html::tag('i', 'SR', ['style' => 'font-style: normal; font-weight: bold;']),
        'visible' => YII_ENV_DEV,
        'items' => [
            ['label' => Yii::t('app', 'Information'), 'url' => ['/speedrunner/information/index']],
            ['label' => Yii::t('app', 'Functions'), 'url' => ['/speedrunner/speedrunner/index']],
        ],
    ],
];
