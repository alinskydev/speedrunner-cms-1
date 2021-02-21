<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\crud\UpdateWidget;

$this->title = Yii::t('app', 'Profile update');
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'save_buttons' => ['save'],
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
                'full_name' => 'text_input',
                'phone' => 'text_input',
                'address' => 'text_area',
                [
                    'name' => 'new_password',
                    'type' => 'text_input',
                    'options' => [
                        'type' => 'password',
                    ],
                ],
            ],
        ],
        
        'design' => [
            'label' => Yii::t('app', 'Design'),
            'attributes' => [
                [
                    'name' => 'design_theme',
                    'type' => 'select',
                    'data' => ArrayHelper::getColumn($model->enums->designThemes(), 'label'),
                ],
                [
                    'name' => 'design_font',
                    'type' => 'select',
                    'data' => ArrayHelper::getColumn($model->enums->designFonts(), 'label'),
                ],
                'design_border_radius' => 'text_input',
            ],
        ],
    ],
]);
