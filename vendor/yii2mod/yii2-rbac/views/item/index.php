<?php

use common\framework\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

$labels = $this->context->getLabels();
$this->title = Yii::t('yii2mod.rbac', $labels['Items']);

$this->params['breadcrumbs'][] = ['label' => Yii::t('yii2mod.rbac', 'RBAC'), 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::a(
        Html::tag('i', null, ['class' => 'fas fa-plus-square']) . Yii::t('yii2mod.rbac', 'Create'),
        ['create'],
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>
</h2>

<div class="main-shadow p-3">
    <?php Pjax::begin(['timeout' => 5000, 'enablePushState' => false]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'common\framework\grid\SerialColumn',
                'headerOptions' => [
                    'style' => 'width: 65px;'
                ],
            ],
            [
                'attribute' => 'name',
                'label' => Yii::t('yii2mod.rbac', 'Name'),
            ],
            [
                'attribute' => 'ruleName',
                'label' => Yii::t('yii2mod.rbac', 'Rule Name'),
                'filter' => ArrayHelper::map(Yii::$app->getAuthManager()->getRules(), 'name', 'name'),
                'filterInputOptions' => ['class' => 'form-control', 'prompt' => Yii::t('yii2mod.rbac', 'Select Rule')],
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'label' => Yii::t('yii2mod.rbac', 'Description'),
            ],
            [
                'class' => 'common\framework\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>
    
    <?php Pjax::end(); ?>
</div>