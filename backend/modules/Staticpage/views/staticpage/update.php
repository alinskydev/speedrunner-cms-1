<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\crud\UpdateWidget;

$this->title = Yii::t('app', 'Static page: {label}', ['label' => $model->label]);
$this->params['breadcrumbs'][] = ['label' => $this->title];

foreach ($blocks as $key => $block_part) {
    $tabs[$block_part[0]->part_index]['label'] = $key;
    
    foreach ($block_part as $b) {
        switch ($b->input_type) {
            case 'text_input':
            case 'text_area':
                $attribute = [
                    'options' => [
                        'id' => "staticpageblock-$b->id",
                        'name' => "StaticpageBlock[$b->id][value]",
                        'value' => $b->value,
                    ],
                ];
                break;
            
            case 'checkbox':
                $attribute = [
                    'options' => [
                        'id' => "staticpageblock-$b->id",
                        'name' => "StaticpageBlock[$b->id][value]",
                        'checked' => $b->value ? true : false,
                    ],
                ];
                break;
            
            case 'file_manager':
            case 'text_editor':
                $attribute = [
                    'options' => [
                        'options' => [
                            'id' => "staticpageblock-$b->id",
                            'name' => "StaticpageBlock[$b->id][value]",
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
                            'id' => "staticpageblock-$b->id",
                            'name' => "StaticpageBlock[$b->id][value][]",
                        ],
                    ],
                    'widget_options' => [
                        'delete_url' => Yii::$app->urlManager->createUrl([
                            'staticpage/staticpage/file-delete', 'id' => $b->id,
                        ]),
                        'sort_url' => Yii::$app->urlManager->createUrl([
                            'staticpage/staticpage/file-sort', 'id' => $b->id,
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
            'type' => $b->input_type,
            'container_options' => [
                'template' => "{beginLabel} {$b->label} {endLabel} {input}{hint}{error}",
            ],
        ], $attribute) : null;
        
        $tabs[$block_part[0]->part_index]['attributes'][] = $attribute;
    }
}

echo UpdateWidget::widget([
    'model' => $new_block,
    'seo_meta_model' => $model,
    'has_seo_meta' => $model->has_seo_meta,
    'save_buttons' => [
        $model->route ? Html::a(
            Html::tag('i', null, ['class' => 'fas fa-external-link-alt']) . Yii::t('app', 'Link'),
            Yii::$app->urlManagerFrontend->createUrl($model->route),
            [
                'class' => 'btn btn-info btn-icon',
                'target' => '_blank',
            ]
        ) : null,
        'save',
    ],
    'form_options' => [
        'fieldConfig' => ['enableClientValidation' => false],
    ],
    'tabs' => $tabs ?? [],
]);
