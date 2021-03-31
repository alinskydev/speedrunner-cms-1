<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\grid\GridView;
use yii\web\JsExpression;
use kartik\select2\Select2;

$this->title = Yii::t('app', 'Blog rates');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
</h2>

<div class="main-shadow p-3">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'backend\widgets\grid\CheckboxColumn',
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
                    'model' => $searchModel,
                    'attribute' => 'blog_id',
                    'data' => [$searchModel->blog_id => ArrayHelper::getValue($searchModel->blog, 'name')],
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
                    'model' => $searchModel,
                    'attribute' => 'user_id',
                    'data' => [$searchModel->user_id => ArrayHelper::getValue($searchModel->user, 'username')],
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
            'mark',
            'created_at',
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
