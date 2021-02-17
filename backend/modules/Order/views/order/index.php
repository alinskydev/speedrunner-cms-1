<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use speedrunner\widgets\grid\GridView;
use kartik\select2\Select2;
use yii\web\JsExpression;

$this->title = Yii::t('app', 'Orders');
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
                            'url' => Yii::$app->urlManager->createUrl(['items-list/users', 'role' => 'registered']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => fn ($model) => ArrayHelper::getValue($model->user, 'username'),
            ],
            [
                'attribute' => 'full_name',
                'format' => 'raw',
                'value' => function ($model) {
                    $result[] = $model->getAttributeLabel('full_name') . ": $model->full_name";
                    $result[] = $model->getAttributeLabel('email') . ": $model->email";
                    $result[] = $model->getAttributeLabel('phone') . ": $model->phone";
                    
                    return implode('<br>', $result);
                }
            ],
            [
                'attribute' => 'delivery_type',
                'format' => 'raw',
                'filter' => ArrayHelper::getColumn($modelSearch->deliveryTypes(), 'label'),
                'value' => fn ($model) => ArrayHelper::getValue($model->deliveryTypes(), "$model->delivery_type.label"),
            ],
            [
                'attribute' => 'payment_type',
                'format' => 'raw',
                'filter' => ArrayHelper::getColumn($modelSearch->paymentTypes(), 'label'),
                'value' => fn ($model) => ArrayHelper::getValue($model->paymentTypes(), "$model->payment_type.label"),
            ],
            [
                'attribute' => 'total_price',
                'format' => 'raw',
                'value' => function ($model) {
                    $prices = ['total_quantity', 'total_price', 'delivery_price'];
                    
                    foreach ($prices as $p) {
                        $result[] = $model->getAttributeLabel($p) . ': ' . ArrayHelper::getValue($model, $p, 0);
                    }
                    
                    $result[] = Yii::t('app', 'Checkout price') . ": " . $model->service->realTotalPrice();
                    
                    return implode('<br>', $result);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => ArrayHelper::getColumn($modelSearch->statuses(), 'label'),
                'value' => fn ($model) => ArrayHelper::getValue($model->statuses(), "$model->status.label"),
                'value' => function ($model) {
                    return Html::tag(
                        'div',
                        ArrayHelper::getValue($model->statuses(), "$model->status.label"),
                        [
                            'class' => 'btn btn-sm btn-block btn-' . ArrayHelper::getValue($model->statuses(), "$model->status.class"),
                            'style' => 'cursor: default;',
                        ]
                    );
                },
            ],
            'created',
            [
                'class' => 'speedrunner\widgets\grid\ActionColumn',
                'template' => '{link} {update} {delete}',
                'buttons' => [
                    'link' => function($url, $model, $key) {
                        return Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-external-link-alt']),
                            Yii::$app->urlManagerFrontend->createUrl(['order/view', 'key' => $model->key]),
                            [
                                'target' => '_blank',
                                'title' => Yii::t('app', 'Link'),
                                'data-toggle' => 'tooltip',
                                'data-pjax' => 0,
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
