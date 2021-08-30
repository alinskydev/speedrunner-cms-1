<?php

use yii\helpers\Html;
use backend\widgets\grid\GridView;

$this->title = Yii::t('app', 'System languages');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->helpers->html->allowedLink(
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
                'header' => false,
                'format' => 'raw',
                'filter' => false,
                'value' => fn ($model) => Html::img(Yii::$app->helpers->image->thumb($model->image, [25, 25])),
                'headerOptions' => [
                    'style' => 'width: 40px;'
                ],
            ],
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            'name',
            'code',
            'is_active:boolean',
            'is_main:boolean',
            'created_at',
            'updated_at',
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template' => '{update} {set_main} {delete}',
                'buttons' => [
                    'set_main' => function($url, $model, $key) {
                        return Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-check-square']),
                            ['set-main', 'id' => $model->id],
                            [
                                'title' => Yii::t('app', 'Set main'),
                                'data-sr-trigger' => 'tooltip',
                                'data-pjax' => 0,
                            ]
                        );
                    },
                ],
                'visibleButtons' => [
                    'set_main' => fn($model, $key, $index) => !$model->is_main,
                ],
            ],
        ],
    ]); ?>
</div>
