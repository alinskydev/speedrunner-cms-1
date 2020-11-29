<?php

use yii\helpers\Html;
use common\components\framework\grid\GridView;

$this->title = Yii::t('app', 'Pages');
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
            [
                'attribute' => 'slug',
                'format' => 'raw',
                'value' => fn ($model) => Html::a($model->slug, Yii::$app->urlManagerFrontend->createUrl(['site/page', 'slug' => $model->slug]), ['target' => '_blank']),
            ],
            'created',
            'updated',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
