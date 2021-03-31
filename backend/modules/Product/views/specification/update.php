<?php

use yii\helpers\Html;
use backend\widgets\crud\UpdateWidget;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {value}', ['value' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product specifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
                'name' => 'text_input',
                'view_filter' => 'checkbox',
                'view_compare' => 'checkbox',
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
