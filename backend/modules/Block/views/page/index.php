<?php

use yii\helpers\Html;
use common\components\framework\grid\GridView;

use backend\modules\Block\models\BlockType;

$this->title = Yii::t('app', 'Block Pages');
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
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->url, Yii::$app->urlManagerFrontend->createUrl(['block/view', 'url' => $model->url]), ['target' => '_blank']);
                }
            ],
            'created',
            'updated',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{assign} {update} {delete}',
                'buttons' => [
                    'assign' => function($url, $model, $key) {
                        return Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-th']) . Yii::t('app', 'Assign'),
                            ['page/assign', 'id' => $model->id]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
