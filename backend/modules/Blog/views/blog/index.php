<?php

use yii\helpers\Html;
use common\components\framework\grid\GridView;
use yii\web\JsExpression;
use kartik\select2\Select2;

$this->title = Yii::t('app', 'Blogs');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::a(
        Html::tag('i', null, ['class' => 'fas fa-plus-square']) . Yii::t('app', 'Create'),
        ['create'],
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>
</h2>

<div class="main-shadow p-3">
    <?= Html::beginForm(['delete'], 'post', ['id' => 'table-edit-form']); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $modelSearch,
        'columns' => [
            [
                'class' => 'common\components\framework\grid\CheckboxColumn',
            ],
            [
                'format' => 'raw',
                'filter' => false,
                'header' => '&nbsp;',
                'value' => function ($model) {
                    return Html::img(Yii::$app->sr->image->thumb($model->image, [40, 40], 'resize'));
                },
                'headerOptions' => [
                    'style' => 'width: 65px;'
                ],
            ],
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            'name',
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->url, Yii::$app->urlManagerFrontend->createUrl(['blog/view', 'url' => $model->url]), ['target' => '_blank']);
                }
            ],
            [
                'attribute' => 'category_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $modelSearch,
                    'attribute' => 'category_id',
                    'data' => isset($modelSearch->category) ? [$modelSearch->category_id => $modelSearch->category->name] : [],
                    'options' => ['placeholder' => ' '],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['blog/category/get-selection-list']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => function ($model) {
                    return $model->category ? $model->category->name : null;
                },
            ],
            [
                'attribute' => 'published',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'data-toggle' => 'datepicker'
                ]
            ],
            [
                'attribute' => 'tags_tmp',
                'value' => 'tagsColumn',
            ],
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>
    
    <?= Html::endForm(); ?>
</div>
