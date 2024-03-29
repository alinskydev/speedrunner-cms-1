<?php

use yii\helpers\Html;
use backend\widgets\grid\GridView;

use backend\modules\Block\models\BlockType;

$this->title = Yii::t('app', 'Block pages');
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
                'class' => 'backend\widgets\grid\CheckboxColumn',
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
                'value' => fn($model) => Html::a(
                    $model->slug,
                    Yii::$app->urlManagerFrontend->createUrl(['block/view', 'slug' => $model->slug]),
                    ['target' => '_blank']
                ),
            ],
            'created_at',
            'updated_at',
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template' => '{assign} {update} {delete}',
                'buttons' => [
                    'assign' => function($url, $model, $key) {
                        return Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-th']),
                            ['assign', 'id' => $model->id],
                            [
                                'title' => Yii::t('app', 'Assign'),
                                'data' => [
                                    'sr-trigger' => 'tooltip',
                                    'pjax' => 0,
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
