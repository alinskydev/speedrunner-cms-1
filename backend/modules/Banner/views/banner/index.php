<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\grid\GridView;

$this->title = Yii::t('app', 'Banners');
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
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            'name',
            [
                'attribute' => 'location',
                'filter' => ArrayHelper::getColumn($searchModel->enums->locations(), 'label'),
                'value' => fn ($model) => ArrayHelper::getValue($model->enums->locations(), "$model->location.label"),
            ],
            'created_at',
            'updated_at',
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
