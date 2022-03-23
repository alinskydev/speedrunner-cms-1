<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\crud\RelationsWidget;
use speedrunner\widgets\TranslationActiveField;

use backend\modules\Banner\models\BannerGroup;

echo RelationsWidget::widget([
    'form' => $form,
    'relations' => ArrayHelper::merge($model->groups, [new BannerGroup()]),
    'name_prefix' => 'Banner[groups_tmp]',
    'attributes' => [
        [
            'name' => 'text_1',
            'type' => 'text_area',
            'container_options' => [
                'class' => TranslationActiveField::className(),
            ],
        ],
        [
            'name' => 'text_2',
            'type' => 'text_area',
            'container_options' => [
                'class' => TranslationActiveField::className(),
            ],
        ],
        [
            'name' => 'text_3',
            'type' => 'text_area',
            'container_options' => [
                'class' => TranslationActiveField::className(),
            ],
        ],
        [
            'name' => 'link',
            'type' => 'text_area',
            'container_options' => [
                'class' => TranslationActiveField::className(),
            ],
        ],
        'image' => 'file_manager',
    ],
]);
