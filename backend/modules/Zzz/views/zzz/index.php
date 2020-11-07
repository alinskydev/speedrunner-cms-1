<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;

use backend\modules\Zzz\models\ZzzCategory;

$this->title = Yii::t('app', 'Zzzs');
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
                'header' => false,
                'format' => 'raw',
                'filter' => false,
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
            'name',
            'slug',
            [
                'attribute' => 'category_id',
                'format' => 'raw',
                'filter' => ArrayHelper::map(ZzzCategory::itemsList('name', 'translation', null)->asArray()->all(), 'id', 'text'),
                'value' => function ($model) {
                    return ArrayHelper::getValue($model->category, 'name');
                },
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'data-toggle' => 'select2',
                ],
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
