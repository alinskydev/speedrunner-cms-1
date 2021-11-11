<?php

use yii\helpers\Html;
use backend\widgets\crud\UpdateWidget;

$this->title = Yii::$app->helpers->html->pageTitle($model, 'label');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Block types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
                'label' => 'text_input',
                'image' => 'file_manager',
            ],
        ],
    ],
]);
