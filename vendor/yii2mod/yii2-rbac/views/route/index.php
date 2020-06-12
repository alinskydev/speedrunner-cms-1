<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii2mod\rbac\RbacRouteAsset;

RbacRouteAsset::register($this);

$this->title = Yii::t('yii2mod.rbac', 'Routes');

$this->params['breadcrumbs'][] = ['label' => Yii::t('yii2mod.rbac', 'RBAC'), 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::a(
        Html::tag('i', null, ['class' => 'fas fa-sync-alt']) . Yii::t('yii2mod.rbac', 'Refresh'),
        ['refresh'],
        ['class' => 'btn btn-primary btn-icon float-right', 'id' => 'btn-refresh']
    ) ?>
</h2>

<?= $this->render('../_dualListBox', [
    'opts' => Json::htmlEncode([
        'items' => $routes,
    ]),
    'assignUrl' => ['assign'],
    'removeUrl' => ['remove'],
]); ?>
