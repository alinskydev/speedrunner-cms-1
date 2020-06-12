<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii2mod\rbac\RbacAsset;

RbacAsset::register($this);

$userName = $model->user->{$usernameField};
$this->title = Yii::t('yii2mod.rbac', 'Assignment: {username}', ['username' => $userName]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('yii2mod.rbac', 'RBAC'), 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii2mod.rbac', 'Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $userName];

?>

<h2 class="main-title">
    <?= $this->title ?>
</h2>

<?= $this->render('../_dualListBox', [
    'opts' => Json::htmlEncode([
        'items' => $model->getItems(),
    ]),
    'assignUrl' => ['assign', 'id' => $model->userId],
    'removeUrl' => ['remove', 'id' => $model->userId],
]); ?>
