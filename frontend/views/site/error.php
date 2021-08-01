<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'An error occurred');

?>

<div class="site-error">
    <h1>
        <?= $exception->statusCode ?: 500 ?>
    </h1>
    
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
</div>
