<?php

use yii\helpers\Html;
use backend\widgets\crud\UpdateWidget;

$this->title = Yii::$app->helpers->html->pageTitle($model);
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
