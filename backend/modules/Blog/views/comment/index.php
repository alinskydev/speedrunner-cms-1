<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;
use yii\web\JsExpression;
use kartik\select2\Select2;

$this->title = Yii::t('app', 'Blog Comments');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
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
                    'data' => isset($modelSearch->blog) ? [$modelSearch->blog_id => $modelSearch->blog->name] : [],
                    'options' => ['placeholder' => ' '],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['blog/blog/items-list']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => function ($model) {
                    return $model->blog ? $model->blog->name : null;
                },
            ],
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $modelSearch,
                    'attribute' => 'user_id',
                    'data' => isset($modelSearch->user) ? [$modelSearch->user_id => $modelSearch->user->username] : [],
                    'options' => ['placeholder' => ' '],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['user/user/items-list']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => function ($model) {
                    return $model->user ? $model->user->username : null;
                },
            ],
            'text:ntext',
            [
                'attribute' => 'status',
                'filter' => ArrayHelper::getColumn(Yii::$app->params['comment_statuses'], function ($value) {
                    return Yii::t('app', $value);
                }),
                'value' => function ($model) {
                    return ArrayHelper::getValue(Yii::$app->params['comment_statuses'], $model->status);
                }
            ],
            'created',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
    
    <?= Html::endForm(); ?>
</div>
