<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\crud\UpdateWidget;

$this->title = Yii::t('app', 'Files update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'SEO'), 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'form_options' => [
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ],
    'save_buttons' => ['save'],
    'tabs' => [
        'robots' => [
            'label' => 'Robots.txt',
            'attributes' => [
                [
                    'name' => 'robots',
                    'type' => 'text_area',
                    'options' => [
                        'rows' => 30,
                    ],
                ],
            ],
        ],
        
        'sitemap' => [
            'label' => 'Sitemap.xml',
            'attributes' => [
                [
                    'name' => 'sitemap',
                    'type' => 'text_input',
                    'options' => [
                        'type' => 'file',
                        'style' => 'height: auto;',
                    ],
                ],
            ],
        ],
    ],
]);
