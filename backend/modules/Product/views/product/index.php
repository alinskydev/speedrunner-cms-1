<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\framework\grid\GridView;
use yii\web\JsExpression;
use kartik\select2\Select2;

$this->title = Yii::t('app', 'Products');
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
                'class' => 'common\framework\grid\CheckboxColumn',
            ],
            [
                'header' => false,
                'format' => 'raw',
                'filter' => false,
                'value' => fn ($model) => Html::img(Yii::$app->services->image->thumb($model->images[0] ?? null, [40, 40], 'resize')),
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
                'value' => fn ($model) => Html::a($model->slug, Yii::$app->urlManagerFrontend->createUrl(['product/view', 'slug' => $model->slug]), ['target' => '_blank']),
            ],
            [
                'attribute' => 'price',
                'format' => 'raw',
                'value' => function ($model) {
                    $result[] = $model->price ? $model->getAttributeLabel('price') . ": $model->price" : null;
                    $result[] = $model->discount ? $model->getAttributeLabel('discount') . ": $model->discount%" : null;
                    
                    return implode('<br>', $result) . '<hr>' . Yii::t('app', 'Total price') . ': ' . $model->realPrice();
                }
            ],
            [
                'attribute' => 'brand_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $modelSearch,
                    'attribute' => 'brand_id',
                    'data' => [$modelSearch->brand_id => ArrayHelper::getValue($modelSearch->brand, 'name')],
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
                'attribute' => 'main_category_id',
                'format' => 'raw',
                'filter' => ArrayHelper::map($categories_list, 'id', 'text'),
                'value' => fn ($model) => ArrayHelper::getValue($model->mainCategory, 'name'),
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'data-toggle' => 'select2',
                ],
            ],
            'created',
            [
                'class' => 'common\framework\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
