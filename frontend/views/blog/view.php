<?php

Yii::$app->sr->seo->registerMeta($model);

?>

<div class="site-index">
    <div class="body-content">
        <div class="row">
            <h2><?= $model->name ?></h2>
            <p><?= $model->published ?></p>
            <p><?= $model->full_description ?></p>
        </div>
    </div>
</div>
