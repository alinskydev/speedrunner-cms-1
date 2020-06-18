<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Error');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="site-error">
    <h2 class="main-title">
        <?= $this->title ?>
    </h2>
    
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($exception->getMessage())) ?>
    </div>
</div>
