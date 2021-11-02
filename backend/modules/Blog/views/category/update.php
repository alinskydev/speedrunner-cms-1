<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\widgets\crud\UpdateWidget;
use speedrunner\widgets\TranslationActiveField;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {value}', ['value' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
                [
                    'name' => 'name',
                    'type' => 'text_input',
                    'container_options' => [
                        'class' => TranslationActiveField::className(),
                    ],
                ],
                'slug' => 'text_input',
                'image' => 'file_manager',
                [
                    'name' => 'description',
                    'type' => 'text_editor',
                    'container_options' => [
                        'class' => TranslationActiveField::className(),
                    ],
                ],
            ],
        ],
    ],
]);
