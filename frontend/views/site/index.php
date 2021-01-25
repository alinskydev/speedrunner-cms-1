<?php

(new \backend\modules\Seo\services\SeoMetaService($page))->register();

?>

<?php foreach ($categories as $c) { ?>
    <?= $c['name'] ?>
    <?= Yii::$app->urlManager->createUrl(['product/catalog', 'url' => $c['slug']]) ?>
<?php } ?>
