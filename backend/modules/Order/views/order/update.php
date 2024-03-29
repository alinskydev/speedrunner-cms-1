<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\crud\UpdateWidget;

$this->title = Yii::$app->helpers->html->pageTitle($model, 'id');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
                [
                    'name' => 'user_id',
                    'type' => 'select2_ajax',
                    'data' => [$model->user_id => ArrayHelper::getValue($model->user, 'username')],
                    'widget_options' => [
                        'ajax_url' => Yii::$app->urlManager->createUrl(['items-list/users']),
                    ]
                ],
                'full_name' => 'text_input',
                'email' => 'text_input',
                'phone' => 'text_input',
                'address' => 'text_area',
                [
                    'name' => 'delivery_type',
                    'type' => 'select',
                    'data' => ArrayHelper::getColumn($model->enums->deliveryTypes(), 'label'),
                ],
                'delivery_price' => 'text_input',
                [
                    'name' => 'payment_type',
                    'type' => 'select',
                    'data' => ArrayHelper::getColumn($model->enums->paymentTypes(), 'label'),
                ],
                '<hr>',
                [
                    'name' => 'total_quantity',
                    'type' => 'text_input',
                    'options' => [
                        'readonly' => true,
                    ]
                ],
                [
                    'name' => 'total_price',
                    'type' => 'text_input',
                    'options' => [
                        'readonly' => true,
                    ]
                ],
            ],
        ],
        
        'products' => [
            'label' => Yii::t('app', 'Products'),
            'attributes' => [
                [
                    'name' => false,
                    'type' => 'render',
                    'view' => '_products',
                ],
            ],
        ],
    ],
]);
