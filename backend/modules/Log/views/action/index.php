<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;
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
                    'data' => [$modelSearch->user_id => ArrayHelper::getValue($modelSearch->user, 'full_name')],
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
                'value' => fn ($model) => ArrayHelper::getValue($model->user, 'full_name'),
            ],
            [
                'attribute' => 'type',
                'filter' => ArrayHelper::getColumn($modelSearch->types(), 'label'),
                'value' => fn ($model) => ArrayHelper::getValue($model->types(), "$model->type.label"),
            ],
            [
                'attribute' => 'model_class',
                'format' => 'raw',
                'filter' => ArrayHelper::map($modelSearch->modelClasses(), 'name', 'label', 'module'),
                'value' => function ($model) {
                    $result[] = Html::tag('b', ArrayHelper::getValue($model->modelClasses(), "$model->model_class.label"));
                    $result[] = '(' . ArrayHelper::getValue($model->modelClasses(), "$model->model_class.module") . ')';
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
                'value' => fn ($model) => $model->attrsColumn('old', 'short'),
                'headerOptions' => [
                    'style' => 'min-width: 300px;',
                ]
            ],
            [
                'attribute' => 'attrs_new',
                'format' => 'raw',
                'value' => fn ($model) => $model->attrsColumn('new', 'short'),
                'headerOptions' => [
                    'style' => 'min-width: 300px;',
                ]
            ],
            'created',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{view} {link}',
                'buttons' => [
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
                    'link' => function ($url, $model, $key) {
                        return Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-external-link-alt']),
                            ArrayHelper::getValue($model->modelClasses($model), "$model->model_class.index_url"),
                            [
                                'target' => '_blank',
                                'title' => Yii::t('app', 'Link'),
                                'data-toggle' => 'tooltip',
                                'data-pjax' => 0,
                            ]
                        );
                    },
                ],
                'visibleButtons' => [
                    'link' => function ($model, $key, $index) {
                        return $model->type != 'deleted' && ArrayHelper::getValue($model->modelClasses($model), "$model->model_class.index_url");
                    },
                ]
            ],
        ],
    ]); ?>
</div>
