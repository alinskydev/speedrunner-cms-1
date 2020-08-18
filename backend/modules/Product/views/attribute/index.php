<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;

$this->title = Yii::t('app', 'Product Attributes');
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
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            'name',
            'code',
            [
                'attribute' => 'type',
                'filter' => $modelSearch->types(),
                'value' => function ($model) {
                    return ArrayHelper::getValue($model->types(), $model->type);
                },
            ],
            'use_filter:boolean',
            'use_compare:boolean',
            'use_detail:boolean',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
