<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;
use yii\web\JsExpression;
use kartik\select2\Select2;

$this->title = Yii::t('app', 'Product rates');
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
                'attribute' => 'product_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $modelSearch,
                    'attribute' => 'product_id',
                    'data' => [$modelSearch->product_id => ArrayHelper::getValue($modelSearch->product, 'name')],
                    'options' => ['placeholder' => ' '],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['items-list/products']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => fn ($model) => ArrayHelper::getValue($model->product, 'name'),
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
            'mark',
            'created',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
