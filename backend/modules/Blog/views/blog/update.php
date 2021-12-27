<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

use backend\widgets\crud\UpdateWidget;
use speedrunner\widgets\TranslationActiveField;

$this->title = Yii::$app->helpers->html->pageTitle($model);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blogs'), 'url' => ['index']];
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
                [
                    'name' => 'category_id',
                    'type' => 'select2_ajax',
                    'data' => [$model->category_id => ArrayHelper::getValue($model->category, 'name')],
                    'widget_options' => [
                        'ajax_url' => Yii::$app->urlManager->createUrl(['items-list/blog-categories']),
                    ]
                ],
                'slug' => 'text_input',
                [
                    'name' => 'published_at',
                    'type' => 'text_input',
                    'options' => [
                        'data-sr-trigger' => 'datetimepicker',
                    ],
                ],
                'image' => 'file_manager',
                [
                    'name' => 'tags_tmp',
                    'type' => 'select2_ajax',
                    'data' => ArrayHelper::map($model->tags, 'id', 'name'),
                    'widget_options' => [
                        'ajax_url' => Yii::$app->urlManager->createUrl(['items-list/blog-tags']),
                        'tags' => true,
                    ],
                    'options' => [
                        'options' => [
                            'multiple' => true,
                            'value' => ArrayHelper::getColumn($model->tags, 'id'),
                        ],
                        'pluginOptions' => [
                            'createTag' => new JsExpression('function(data) {
                                return {
                                    id: data.term,
                                    text: "' . Yii::t('app', 'Create') . ': " + data.term,
                                    newTag: true
                                };
                            }'),
                        ],
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
        
        'images' => [
            'label' => Yii::t('app', 'Images'),
            'attributes' => [
                [
                    'name' => 'images',
                    'type' => 'files',
                    'multiple' => true,
                    'widget_options' => [
                        'delete_url' => Yii::$app->urlManager->createUrl([
                            'blog/blog/file-delete', 'id' => $model->id, 'attr' => 'images'
                        ]),
                        'sort_url' => Yii::$app->urlManager->createUrl([
                            'blog/blog/file-sort', 'id' => $model->id, 'attr' => 'images'
                        ]),
                    ],
                ],
            ],
        ],
    ],
]);
