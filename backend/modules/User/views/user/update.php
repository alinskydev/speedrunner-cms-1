<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use backend\widgets\crud\UpdateWidget;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {value}', ['value' => $model->username]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
                'username' => 'text_input',
                'email' => 'text_input',
                [
                    'name' => 'role',
                    'type' => 'select',
                    'data' => ArrayHelper::getColumn($model->enums->roles(), 'label'),
                ],
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
        
        'profile' => [
            'label' => Yii::t('app', 'Profile'),
            'attributes' => [
                [
                    'name' => 'image',
                    'type' => 'files',
                    'multiple' => false,
                    'widget_options' => [
                        'delete_url' => Yii::$app->urlManager->createUrl([
                            'user/user/file-delete', 'id' => $model->id, 'attr' => 'image'
                        ]),
                    ]
                ],
                'full_name' => 'text_input',
                'phone' => 'text_input',
                'address' => 'text_area',
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
