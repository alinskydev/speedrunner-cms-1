<?php

Yii::$app->sr->seo->registerMeta($page);

?>

<?php foreach ($cats as $c) { ?>
    <?= $c->name ?>
    <?= Yii::$app->urlManager->createUrl(['product/catalog', 'full_url' => $c->fullUrl()]) ?>
<?php } ?>
