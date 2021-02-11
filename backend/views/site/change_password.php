<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\widgets\crud\UpdateWidget;

$this->title = Yii::t('app', 'Password changing');
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'save_buttons' => ['save'],
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
                [
                    'name' => 'new_password',
                    'type' => 'text_input',
                    'container_options' => [
                        'enableClientValidation' => false,
                    ],
                    'options' => [
                        'type' => 'password',
                    ],
                ],
            ],
        ],
    ],
]);
