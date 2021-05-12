<?php

use backend\widgets\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = Yii::t('yii2mod.rbac', 'Assignments');

$this->params['breadcrumbs'][] = ['label' => Yii::t('yii2mod.rbac', 'RBAC'), 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
</h2>

<div class="main-shadow p-3">
    <?php Pjax::begin(['timeout' => 5000]); ?>
    
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => ArrayHelper::merge($gridViewColumns, [
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template' => '{view}',
            ],
        ]),
    ]); ?>
    
    <?php Pjax::end(); ?>
</div>
