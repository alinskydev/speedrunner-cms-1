<?php

use yii\helpers\Html;
use backend\widgets\grid\GridView;

$this->title = Yii::t('app', 'Pages');
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
                'header' => false,
                'format' => 'raw',
                'filter' => false,
                'value' => fn ($model) => Html::img(Yii::$app->services->image->thumb($model->image, [40, 40])),
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
            'name',
            [
                'attribute' => 'slug',
                'format' => 'raw',
                'value' => fn ($model) => Html::a(
                    $model->slug,
                    Yii::$app->urlManagerFrontend->createUrl(['site/page', 'slug' => $model->slug]),
                    ['target' => '_blank']
                ),
            ],
            'created_at',
            'updated_at',
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
