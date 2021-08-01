<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\grid\GridView;

$this->title = Yii::t('app', 'Block types');
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
                'header' => false,
                'format' => 'raw',
                'filter' => false,
                'value' => fn ($model) => Html::img(Yii::$app->helpers->image->thumb($model->image, [40, 40])),
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
            'label',
            [
                'attribute' => 'input_type',
                'filter' => Yii::$app->params['input_types'],
                'value' => fn ($model) => ArrayHelper::getValue(Yii::$app->params['input_types'], $model->input_type),
            ],
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
