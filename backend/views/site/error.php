<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'An error occurred');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="site-error">
    <h2 class="main-title">
        <?= $exception->getName() ?>
    </h2>
    
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($exception->getMessage())) ?>
    </div>
</div>
