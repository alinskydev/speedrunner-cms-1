<?php

Yii::$app->sr->seo->registerMeta($page);

?>

<?php foreach ($categories as $c) { ?>
    <?= $c->name ?>
    <?= Yii::$app->urlManager->createUrl(['product/catalog', 'url' => $c->url()]) ?>
<?php } ?>
