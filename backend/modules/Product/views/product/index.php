<?php

use yii\helpers\Html;
use common\components\framework\grid\GridView;
use yii\helpers\ArrayHelper;
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
                    return $model->images ? Html::img(Yii::$app->sr->image->thumb($model->images[0]->image, [50, 50], 'resize')) : null;
                },
                'headerOptions' => [
                    'style' => 'width: 90px;'
                ],
            ],
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            'name',
            'price',
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->url, Yii::$app->urlManagerFrontend->createUrl(['product/view', 'url' => $model->url]), ['target' => '_blank']);
                }
            ],
            'is_active:boolean',
            [
                'attribute' => 'brand_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $modelSearch,
                    'attribute' => 'brand_id',
                    'data' => isset($modelSearch->brand) ? [$modelSearch->brand_id => $modelSearch->brand->name] : [],
                    'options' => ['placeholder' => ' '],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['product/brand/get-selection-list']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => function ($model) {
                    return $model->brand ? $model->brand->name : null;
                },
            ],
            [
                'attribute' => 'main_category_id',
                'format' => 'raw',
                'filter' => ProductCategory::getItemsList([1]),
                'value' => function ($model) {
                    return $model->mainCat ? $model->mainCat->name : null;
                },
                'filterInputOptions' => [
                    'data-toggle' => 'selectpicker'
                ],
            ],
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
    
    <?= Html::endForm(); ?>
</div>
