<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;

$this->title = Yii::t('app', 'Banners');
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
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            'name',
            [
                'attribute' => 'location',
                'filter' => $modelSearch->locations(),
                'value' => function ($model) {
                    return ArrayHelper::getValue($model->locations(), $model->location);
                },
            ],
            'created',
            'updated',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
