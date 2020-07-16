<?php

Yii::$app->sr->seo->registerMeta($model);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['blog/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

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
