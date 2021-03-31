<?php

$page->registerSeoMeta();

$this->title = Yii::$app->services->settings->site_name;

?>

<?php foreach ($categories as $c) { ?>
    <?= $c['name'] ?>
    <?= Yii::$app->urlManager->createUrl(['product/catalog', 'url' => $c['slug']]) ?>
<?php } ?>
