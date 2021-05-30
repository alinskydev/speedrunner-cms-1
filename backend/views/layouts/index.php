<?php

use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Alert;
use backend\widgets\layout\Menu;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#067a7d">
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web/favicon.svg') ?>">
    
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<div class="nav-wrapper-full opened">
    <a href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>" class="site-logo">
        <img src="<?= Yii::$app->urlManager->createFileUrl('/img/logo.svg') ?>" alt="">
    </a>
    
    <nav class="container-fluid">
        <?= Menu::widget([
            'items' => require '_nav.php',
            'options' => ['class' => 'nav-items'],
            'labelTemplate' => '<div class="parent h4 font-weight-normal">{label}</div>',
            'submenuTemplate' => '<ul class="items">{items}</ul>',
            'encodeLabels' => false,
            'activateParents' => true,
        ]); ?>
    </nav>
</div>

<div id="main-alert">
    <?= json_encode(Yii::$app->session->getAllFlashes(), JSON_UNESCAPED_UNICODE) ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
