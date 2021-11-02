<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\widgets\crud\UpdateWidget;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {value}', ['value' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Block pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

foreach ($blocks as $key => $b) {
    switch ($b->type->input_type) {
        case 'text_input':
        case 'text_area':
            $attribute = [
                'options' => [
                    'id' => "block-$b->id",
                    'name' => "Block[$b->id][value]",
                    'value' => $b->value,
                ],
            ];
            break;
        
        case 'checkbox':
            $attribute = [
                'options' => [
                    'id' => "block-$b->id",
                    'name' => "Block[$b->id][value]",
                    'checked' => $b->value ? true : false,
                ],
            ];
            break;
        
        case 'file_manager':
        case 'text_editor':
            $attribute = [
                'options' => [
                    'options' => [
                        'id' => "block-$b->id",
                        'name' => "Block[$b->id][value]",
                        'value' => $b->value,
                    ],
                ],
            ];
            break;
        
        case 'files':
            $attribute = [
                'multiple' => true,
                'value' => $b->value,
                'options' => [
                    'options' => [
                        'id' => "block-$b->id",
                        'name' => "Block[$b->id][value][]",
                    ],
                ],
                'widget_options' => [
                    'delete_url' => Yii::$app->urlManager->createUrl([
                        'block/page/file-delete', 'id' => $b->id,
                    ]),
                    'sort_url' => Yii::$app->urlManager->createUrl([
                        'block/page/file-sort', 'id' => $b->id,
                    ]),
                ],
            ];
            break;
        
        case 'groups':
            $attribute = [
                'name' => false,
                'type' => 'render',
                'model' => $b,
                'view' => '_groups',
            ];
            break;
    }
    
    $attribute = $attribute ? ArrayHelper::merge([
        'name' => 'value',
        'type' => $b->type->input_type,
        'container_options' => [
            'template' => "{beginLabel} {$b->type->label} {endLabel} {input}{hint}{error}",
        ],
    ], $attribute) : null;
    
    $tabs[$b->id] = [
        'label' => $b->type->label,
        'attributes' => [$attribute],
    ];
}

echo UpdateWidget::widget([
    'model' => $new_block,
    'seo_meta_model' => $model,
    'form_options' => [
        'fieldConfig' => ['enableClientValidation' => false],
    ],
    'tabs' => $tabs ?? [],
]);
