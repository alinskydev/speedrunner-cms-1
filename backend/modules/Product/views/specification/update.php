<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\widgets\crud\UpdateWidget;
use speedrunner\widgets\TranslationActiveField;

$this->title = Yii::$app->helpers->html->pageTitle($model);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product specifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
                [
                    'name' => 'name',
                    'type' => 'text_input',
                    'container_options' => [
                        'class' => TranslationActiveField::className(),
                    ],
                ],
                'show_in_filter' => 'checkbox',
                'show_in_compare' => 'checkbox',
            ],
        ],
        
        'options' => [
            'label' => Yii::t('app', 'Options'),
            'attributes' => [
                [
                    'name' => false,
                    'type' => 'render',
                    'view' => '_options',
                ],
            ],
        ],
    ],
]);
