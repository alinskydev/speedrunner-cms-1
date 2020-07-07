<?php

use yii\helpers\Html;

$this->title = $exception->getMessage();

?>

<div class="site-error">
    <h1><?= $exception->statusCode ?></h1>
    
    <div class="alert alert-danger">
        <?= $this->title ?>
    </div>
</div>
