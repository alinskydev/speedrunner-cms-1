<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\grid\GridView;
use yii\web\JsExpression;
use kartik\select2\Select2;

$this->title = Yii::t('app', 'Users');
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
            'username',
            [
                'attribute' => 'role_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'role_id',
                    'data' => [$searchModel->role_id => ArrayHelper::getValue($searchModel->role, 'name')],
                    'options' => ['placeholder' => ' '],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['items-list/user-roles']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => fn ($model) => ArrayHelper::getValue($model->role, 'name'),
            ],
            'email:email',
            'full_name',
            'phone',
            'created_at',
            'updated_at',
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
