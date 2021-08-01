<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\grid\GridView;
use yii\web\JsExpression;
use kartik\select2\Select2;

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->helpers->html->allowedLink(
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
                'class' => 'backend\widgets\grid\CheckboxColumn',
            ],
            [
                'header' => false,
                'format' => 'raw',
                'filter' => false,
                'value' => fn ($model) => Html::img(Yii::$app->helpers->image->thumb($model->images[0] ?? null, [40, 40])),
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
                'attribute' => 'slug',
                'format' => 'raw',
                'value' => fn ($model) => Html::a(
                    $model->slug,
                    Yii::$app->urlManagerFrontend->createUrl(['product/view', 'slug' => $model->slug]),
                    ['target' => '_blank']
                ),
            ],
            [
                'attribute' => 'main_category_id',
                'format' => 'raw',
                'filter' => ArrayHelper::map($categories, 'id', 'text'),
                'value' => fn ($model) => ArrayHelper::getValue($model->mainCategory, 'name'),
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'data-sr-trigger' => 'select2',
                ],
            ],
            [
                'attribute' => 'brand_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'brand_id',
                    'data' => [$searchModel->brand_id => ArrayHelper::getValue($searchModel->brand, 'name')],
                    'options' => ['placeholder' => ' '],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['items-list/product-brands']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => fn ($model) => ArrayHelper::getValue($model->brand, 'name'),
            ],
            [
                'attribute' => 'price',
                'format' => 'raw',
                'value' => function ($model) {
                    $result[] = $model->price ? $model->getAttributeLabel('price') . ": $model->price" : null;
                    $result[] = $model->discount ? $model->getAttributeLabel('discount') . ": $model->discount%" : null;
                    
                    return implode('<br>', $result) . '<hr>' . Yii::t('app', 'Total price') . ': ' . $model->service->realPrice();
                }
            ],
            'quantity',
            'created_at',
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
