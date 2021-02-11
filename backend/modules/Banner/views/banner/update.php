<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\widgets\crud\UpdateWidget;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {value}', ['value' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
                'name' => 'text_input',
            ],
        ],
        
        'groups' => [
            'label' => Yii::t('app', 'Groups'),
            'attributes' => [
                [
                    'name' => false,
                    'type' => 'render',
                    'view' => '_groups',
                ],
            ],
        ],
    ],
]);
