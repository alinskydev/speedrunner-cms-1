<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\modules\Staticpage\models\Staticpage;

return [
    [
        'label' => Html::tag('i', null, ['class' => 'fas fa-user']) . Yii::t('app', 'Users'),
        'items' => [
            ['label' => Yii::t('app', 'Users'), 'url' => ['/user/user/index']],
            ['label' => Yii::t('app', 'RBAC'), 'url' => ['/rbac/rbac/index']],
        ],
    ],
    [
        'label' => Html::tag('i', null, ['class' => 'fas fa-file-alt']) . Yii::t('app', 'Static pages'),
        'items' => ArrayHelper::getColumn(Staticpage::find()->asArray()->all(), function($value) {
            return ['label' => $value['label'], 'url' => ['/staticpage/staticpage/update', 'name' => $value['name']]];
        }),
    ],
    [
        'label' => Html::tag('i', null, ['class' => 'fas fa-server']) . Yii::t('app', 'Content'),
        'items' => [
            ['label' => Yii::t('app', 'Menu'), 'url' => ['/menu/menu/tree']],
            ['label' => Yii::t('app', 'Pages'), 'url' => ['/page/page/index']],
            ['label' => Yii::t('app', 'Banners'), 'url' => ['/banner/banner/index']],
        ],
    ],
    [
        'label' => Html::tag('i', null, ['class' => 'fas fa-th']) . Yii::t('app', 'Blocks'),
        'items' => [
            ['label' => Yii::t('app', 'Types'), 'url' => ['/block/type/index']],
            ['label' => Yii::t('app', 'Pages'), 'url' => ['/block/page/index']],
        ],
    ],
    [
        'label' => Html::tag('i', null, ['class' => 'fas fa-newspaper']) . Yii::t('app', 'Blogs'),
        'items' => [
            ['label' => Yii::t('app', 'Blogs'), 'url' => ['/blog/blog/index']],
            ['label' => Yii::t('app', 'Categories'), 'url' => ['/blog/category/index']],
            ['label' => Yii::t('app', 'Tags'), 'url' => ['/blog/tag/index']],
            ['label' => Yii::t('app', 'Comments'), 'url' => ['/blog/comment/index']],
            ['label' => Yii::t('app', 'Rates'), 'url' => ['/blog/rate/index']],
        ],
    ],
    [
        'label' => Html::tag('i', null, ['class' => 'fas fa-boxes']) . Yii::t('app', 'Products'),
        'items' => [
            ['label' => Yii::t('app', 'Products'), 'url' => ['/product/product/index']],
            ['label' => Yii::t('app', 'Categories'), 'url' => ['/product/category/tree']],
            ['label' => Yii::t('app', 'Brands'), 'url' => ['/product/brand/index']],
            ['label' => Yii::t('app', 'Specifications'), 'url' => ['/product/specification/index']],
            ['label' => Yii::t('app', 'Comments'), 'url' => ['/product/comment/index']],
            ['label' => Yii::t('app', 'Rates'), 'url' => ['/product/rate/index']],
        ],
    ],
    [
        'label' => Html::tag('i', null, ['class' => 'fas fa-shopping-cart']) . Yii::t('app', 'Orders'),
        'items' => [
            ['label' => Yii::t('app', 'Orders'), 'url' => ['/order/order/index']],
        ],
    ],
    
    [
        'label' => Html::tag('i', null, ['class' => 'fas fa-cogs']) . Yii::t('app', 'System'),
        'items' => [
            ['label' => Yii::t('app', 'Settings'),'url' => ['/system/settings/update']],
            ['label' => Yii::t('app', 'Languages'), 'url' => ['/system/language/index']],
            ['label' => Yii::t('app', 'Translations'), 'url' => ['/translation/source/index']],
            ['label' => Yii::t('app', 'Log actions'), 'url' => ['/log/action/index']],
        ],
    ],
    [
        'label' => Html::tag('i', null, ['class' => 'fas fa-trash-alt']) . Yii::t('app', 'Cache'),
        'items' => [
            ['label' => Yii::t('app', 'Remove thumbs'), 'url' => ['/cache/remove-thumbs']],
            ['label' => Yii::t('app', 'Clear'), 'url' => ['/cache/clear']],
        ],
    ],
    [
        'label' => Html::tag('i', 'SR', ['style' => 'font-style: normal; font-weight: bold;']) . Yii::t('app', 'Speedrunner'),
        'items' => [
            ['label' => Yii::t('app', 'Information'), 'url' => ['/speedrunner/information/index']],
            ['label' => Yii::t('app', 'Functions'), 'url' => ['/speedrunner/speedrunner/index']],
        ],
    ],
];

?>
