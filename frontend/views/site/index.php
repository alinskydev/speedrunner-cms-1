<?php

Yii::$app->sr->seo->registerMeta($page);

?>

<h1><?= Yii::t('app', 'Home_pg', ['dot' => true]) ?></h1>

<?= Yii::$app->sr->image->thumb(Yii::$app->settings->site_logo, [140, 150], 'crop') ?>

<?= Yii::t('app', 'test', ['dot' => true]) ?>

<div class="site-index">
    <div class="body-content">
        <div class="row">
            <?php foreach ($cats as $c) { ?>
                <div class="col-md-3">
                    <h2><?= $c->name ?></h2>
                    <a class="btn btn-default" href="<?= Yii::$app->urlManager->createUrl(['product/catalog', 'full_url' => $c->full_url]) ?>">link</a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
