<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;

$this->title = Yii::t('app', 'Users');
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
        'buttons' => [],
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            'username',
            [
                'attribute' => 'role',
                'filter' => $modelSearch->roles,
                'value' => function ($model) {
                    return ArrayHelper::getValue($model->roles, $model->role);
                },
            ],
            'email:email',
            'full_name',
            'phone',
            'created',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
