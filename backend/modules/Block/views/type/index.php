<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;

$this->title = Yii::t('app', 'Block Types');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
</h2>

<div class="main-shadow p-3">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $modelSearch,
        'buttons' => [],
        'columns' => [
            [
                'format' => 'raw',
                'filter' => false,
                'header' => '&nbsp;',
                'value' => function ($model) {
                    return Html::img(Yii::$app->sr->image->thumb($model->image, [40, 40], 'resize'));
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
            'label',
            [
                'attribute' => 'type',
                'filter' => Yii::$app->params['input_types'],
                'value' => function ($model) {
                    return ArrayHelper::getValue(Yii::$app->params['input_types'], $model->type);
                },
            ],
            'has_translation:boolean',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
