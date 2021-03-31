<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\grid\GridView;

$this->title = Yii::t('app', 'Product specifications');
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
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'backend\widgets\grid\CheckboxColumn',
            ],
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            'name',
            'view_filter:boolean',
            'view_compare:boolean',
            'created_at',
            'updated_at',
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
