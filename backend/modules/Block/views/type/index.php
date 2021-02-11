<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\framework\grid\GridView;

$this->title = Yii::t('app', 'Block types');
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
                'header' => false,
                'format' => 'raw',
                'filter' => false,
                'value' => fn ($model) => Html::img(Yii::$app->services->image->thumb($model->image, [40, 40], 'resize')),
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
                'attribute' => 'type',
                'filter' => Yii::$app->params['input_types'],
                'value' => fn ($model) => ArrayHelper::getValue(Yii::$app->params['input_types'], $model->type),
            ],
            [
                'class' => 'common\framework\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
