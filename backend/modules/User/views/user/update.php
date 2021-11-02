<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\crud\UpdateWidget;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {value}', ['value' => $model->id]);
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
                    'name' => 'role_id',
                    'type' => 'select2_ajax',
                    'data' => [$model->role_id => ArrayHelper::getValue($model->role, 'name')],
                    'widget_options' => [
                        'ajax_url' => Yii::$app->urlManager->createUrl(['items-list/user-roles']),
                    ]
                ],
                [
                    'name' => 'new_password',
                    'type' => 'text_input',
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
                    'options' => [
                        'pluginOptions' => [
                            'initialPreviewConfig' => [['key' => $model->image, 'downloadUrl' => $model->image]],
                        ],
                    ],
                    'widget_options' => [
                        'delete_url' => Yii::$app->urlManager->createUrl([
                            'user/user/file-delete', 'id' => $model->id, 'attr' => 'image'
                        ]),
                    ],
                ],
                'full_name' => 'text_input',
                'phone' => 'text_input',
                'address' => 'text_area',
            ],
        ],
    ],
]);
