<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\widgets\crud\UpdateWidget;
use speedrunner\widgets\TranslationActiveField;

$this->title = Yii::$app->helpers->html->pageTitle($model);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

$related = $model->service->related();

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
                [
                    'name' => 'brand_id',
                    'type' => 'select2_ajax',
                    'data' => [$model->brand_id => ArrayHelper::getValue($model->brand, 'name')],
                    'widget_options' => [
                        'ajax_url' => Yii::$app->urlManager->createUrl(['items-list/product-brands']),
                    ]
                ],
                [
                    'name' => 'short_description',
                    'type' => 'text_area',
                    'container_options' => [
                        'class' => TranslationActiveField::className(),
                    ],
                ],
                [
                    'name' => 'full_description',
                    'type' => 'text_editor',
                    'container_options' => [
                        'class' => TranslationActiveField::className(),
                    ],
                ],
            ],
        ],
        
        'stock' => [
            'label' => Yii::t('app', 'Stock'),
            'attributes' => [
                Html::tag('div', Yii::t('app', 'Values will be taken automatically from the first variation (if any)'), [
                    'class' => 'alert alert-info mb-4',
                ]),
                'price' => 'text_input',
                'discount' => 'text_input',
                'quantity' => 'text_input',
                'sku' => 'text_input',
            ],
        ],
        
        'images' => [
            'label' => Yii::t('app', 'Images'),
            'attributes' => [
                [
                    'name' => 'images',
                    'type' => 'files',
                    'multiple' => true,
                    'widget_options' => [
                        'delete_url' => Yii::$app->urlManager->createUrl([
                            'product/product/file-delete', 'id' => $model->id, 'attr' => 'images'
                        ]),
                        'sort_url' => Yii::$app->urlManager->createUrl([
                            'product/product/file-sort', 'id' => $model->id, 'attr' => 'images'
                        ]),
                    ]
                ],
            ],
        ],
        
        'categories_specifications' => [
            'label' => Yii::t('app', 'Categories & Specifications'),
            'attributes' => [
                [
                    'name' => 'main_category_id',
                    'type' => 'select',
                    'data' => ArrayHelper::map($categories['list'], 'id', 'text'),
                    'options' => [
                        'data-sr-trigger' => 'select2',
                        'prompt' => ' ',
                    ],
                ],
                [
                    'name' => false,
                    'type' => 'render',
                    'view' => '_categories',
                    'params' => [
                        'data' => $categories['tree'],
                    ],
                ],
            ],
        ],
        
        'variations' => [
            'label' => Yii::t('app', 'Variations'),
            'attributes' => [
                [
                    'name' => false,
                    'type' => 'render',
                    'view' => '_variations',
                ],
            ],
        ],
        
        'related' => [
            'label' => Yii::t('app', 'Related'),
            'attributes' => [
                [
                    'name' => 'related_ids',
                    'type' => 'select2_ajax',
                    'data' => ArrayHelper::map($related, 'id', 'name'),
                    'widget_options' => [
                        'ajax_url' => Yii::$app->urlManager->createUrl(['items-list/products', 'id' => $model->id]),
                    ],
                    'options' => [
                        'options' => [
                            'multiple' => true,
                            'value' => ArrayHelper::getColumn($related, 'id'),
                        ],
                    ]
                ],
            ],
        ],
    ],
]);
