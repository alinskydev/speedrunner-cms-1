<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use speedrunner\widgets\grid\GridView;
use kartik\select2\Select2;
use yii\web\JsExpression;

$this->title = Yii::t('app', 'Log actions');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
</h2>

<div class="main-shadow p-3">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $modelSearch,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ],
            ],
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $modelSearch,
                    'attribute' => 'user_id',
                    'data' => [$modelSearch->user_id => ArrayHelper::getValue($modelSearch->user, 'username')],
                    'options' => ['placeholder' => ' '],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['items-list/users']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => fn ($model) => ArrayHelper::getValue($model->user, 'username'),
            ],
            [
                'attribute' => 'type',
                'filter' => ArrayHelper::getColumn($modelSearch->types(), 'label'),
                'value' => fn ($model) => ArrayHelper::getValue($model->types(), "$model->type.label"),
            ],
            [
                'attribute' => 'model_class',
                'format' => 'raw',
                'filter' => ArrayHelper::map($log_action_modules_list, 'name', 'label', 'module'),
                'value' => function ($model) use ($log_action_modules_list) {
                    $result[] = Html::tag('b', ArrayHelper::getValue($log_action_modules_list, "$model->model_class.label"));
                    $result[] = '(' . ArrayHelper::getValue($log_action_modules_list, "$model->model_class.module") . ')';
                    $result[] = "Id: $model->model_id";
                    
                    return implode('<br>', $result);
                },
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'data-toggle' => 'select2',
                ]
            ],
            [
                'attribute' => 'attrs_old',
                'format' => 'raw',
                'value' => fn ($model) => $model->service->attrsColumn('old', 'short'),
                'headerOptions' => [
                    'style' => 'min-width: 300px;',
                ]
            ],
            [
                'attribute' => 'attrs_new',
                'format' => 'raw',
                'value' => fn ($model) => $model->service->attrsColumn('new', 'short'),
                'headerOptions' => [
                    'style' => 'min-width: 300px;',
                ]
            ],
            'created',
            [
                'class' => 'speedrunner\widgets\grid\ActionColumn',
                'template' => '{view} {link}',
                'buttons' => [
                    'link' => function ($url, $model, $key) {
                        return Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-external-link-alt']),
                            ArrayHelper::getValue($model->service->findAndFill(), 'index_url'),
                            [
                                'target' => '_blank',
                                'title' => Yii::t('app', 'Link'),
                                'data-toggle' => 'tooltip',
                                'data-pjax' => 0,
                            ]
                        );
                    },
                    'view' => function ($url, $model, $key) {
                        return Html::button(
                            Html::tag('i', null, [
                                'class' => 'fas fa-eye',
                                'data-toggle' => 'ajax-button',
                                'data-action' => Yii::$app->urlManager->createUrl(['log/action/view', 'id' => $model->id]),
                                'data-type' => 'modal',
                            ]),
                            [
                                'class' => 'btn btn-link p-0',
                                'data-pjax' => 0,
                                'title' => Yii::t('app', 'View'),
                                'data-toggle' => 'tooltip',
                            ]
                        );
                    },
                ],
                'visibleButtons' => [
                    'link' => function ($model, $key, $index) {
                        return $model->type != 'deleted' && ArrayHelper::getValue($model->service->findAndFill(), 'index_url');
                    },
                ]
            ],
        ],
    ]); ?>
</div>
