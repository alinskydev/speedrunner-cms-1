<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\widgets\crud\UpdateWidget;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {value}', ['value' => $model->label]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Block types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
                'label' => 'text_input',
                'image' => 'elfinder',
            ],
        ],
    ],
]);
