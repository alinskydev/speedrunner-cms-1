<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use speedrunner\widgets\grid\GridView;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\bootstrap\Dropdown;

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = ['label' => $this->title];

$enums_class_name = str_replace('\models\\', '\enums\\', $searchModel->className()) . 'Enums';

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
        'filterModel' => $searchModel,
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
                    'model' => $searchModel,
                    'attribute' => 'user_id',
                    'data' => [$searchModel->user_id => ArrayHelper::getValue($searchModel->user, 'username')],
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
                'filter' => ArrayHelper::getColumn($searchModel->enums->deliveryTypes(), 'label'),
                'value' => fn ($model) => ArrayHelper::getValue($model->enums->deliveryTypes(), "$model->delivery_type.label"),
            ],
            [
                'attribute' => 'payment_type',
                'format' => 'raw',
                'filter' => ArrayHelper::getColumn($searchModel->enums->paymentTypes(), 'label'),
                'value' => fn ($model) => ArrayHelper::getValue($model->enums->paymentTypes(), "$model->payment_type.label"),
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
                'filter' => ArrayHelper::getColumn($searchModel->enums->statuses(), 'label'),
                'value' => fn ($model) => ArrayHelper::getValue($model->enums->statuses(), "$model->status.label"),
                'value' => function ($model) {
                    $result = Html::a(
                        ArrayHelper::getValue($model->enums->statuses(), "$model->status.label") . Html::tag('b', null, ['class' => 'caret']),
                        '#',
                        [
                            'data-toggle' => 'dropdown',
                            'class' => 'dropdown-toggle btn btn-block btn-' . ArrayHelper::getValue($model->enums->statuses(), "$model->status.class"),
                        ]
                    );
                    
                    $result .= Dropdown::widget([
                        'items' => array_map(function ($key, $value) use ($model) {
                            return [
                                'label' => $value['label'],
                                'url' => ['change-status', 'id' => $model->id, 'status' => $key],
                                'linkOptions' => ['class' => 'dropdown-item'],
                            ];
                        }, array_keys($model->enums->statuses()), $model->enums->statuses()),
                        'options' => [
                            'class' => 'dropdown-menu',
                        ],
                    ]);
                    
                    return Html::tag('div', $result, ['class' => 'dropdown']);
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
