<?php

use yii\helpers\Html;
use backend\widgets\crud\UpdateWidget;

$this->title = Yii::t('app', 'SEO meta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'SEO'), 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'save_buttons' => ['save'],
    'tabs' => [
        'seo_meta' => [
            'label' => Yii::t('app', 'SEO meta'),
            'attributes' => [
                [
                    'name' => false,
                    'type' => 'render',
                    'view' => 'meta',
                ],
            ],
        ],
    ],
]);
