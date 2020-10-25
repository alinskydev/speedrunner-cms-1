<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;
use yii\web\JsExpression;
use kartik\select2\Select2;

use backend\modules\Product\models\ProductCategory;

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
                'class' => 'common\components\framework\grid\CheckboxColumn',
            ],
            [
                'format' => 'raw',
                'filter' => false,
                'header' => '&nbsp;',
                'value' => function ($model) {
                    return $model->images ? Html::img(Yii::$app->sr->image->thumb($model->images[0], [40, 40], 'resize')) : null;
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
                'attribute' => 'slug',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->slug, Yii::$app->urlManagerFrontend->createUrl(['product/view', 'slug' => $model->slug]), ['target' => '_blank']);
                }
            ],
            'price',
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
                'value' => function ($model) {
                    return ArrayHelper::getValue($model->brand, 'name');
                },
            ],
            [
                'attribute' => 'main_category_id',
                'format' => 'raw',
                'filter' => ProductCategory::itemsTree([1]),
                'value' => function ($model) {
                    return ArrayHelper::getValue($model->mainCategory, 'name');
                },
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'data-toggle' => 'select2',
                ],
            ],
            'created',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
