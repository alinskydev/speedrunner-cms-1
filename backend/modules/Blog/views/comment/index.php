<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;
use yii\web\JsExpression;
use kartik\select2\Select2;

$this->title = Yii::t('app', 'Blog comments');
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
                'class' => 'common\components\framework\grid\CheckboxColumn',
            ],
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            [
                'attribute' => 'blog_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $modelSearch,
                    'attribute' => 'blog_id',
                    'data' => [$modelSearch->blog_id => ArrayHelper::getValue($modelSearch->blog, 'name')],
                    'options' => ['placeholder' => ' '],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['items-list/blogs']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => fn ($model) => ArrayHelper::getValue($model->blog, 'name'),
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
            'text:ntext',
            [
                'attribute' => 'status',
                'filter' => ArrayHelper::getColumn(Yii::$app->params['comment_statuses'], fn ($value) => Yii::t('app', $value)),
                'value' => fn ($model) => ArrayHelper::getValue(Yii::$app->params['comment_statuses'], $model->status),
            ],
            'created',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
