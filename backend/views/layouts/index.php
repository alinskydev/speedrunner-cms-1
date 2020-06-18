<?php

use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Alert;

AppAsset::register($this);

if (Yii::$app->settings->use_mobile_grid) {
    $this->registerCssFile('@web/css/mobile-grid.css', ['depends' => [AppAsset::className()]]);
}

if (Yii::$app->session->get('theme_dark')) {
    $this->registerCssFile('@web/css/theme-dark.css', ['depends' => [AppAsset::className()]]);
}

//-----------------------------------------------------------------------------------

$is_home = Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index';
$user = Yii::$app->user->identity;

$langs = Yii::$app->i18n->getLanguages(true);
$lang_curr = Yii::$app->i18n->getLanguage();

$flashes = Yii::$app->session->getAllFlashes();
$flashes = json_encode($flashes, JSON_UNESCAPED_UNICODE);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="elfinder-connection-url" content="<?= Yii::$app->urlManagerBackend->createUrl(['connection/elfinder-file-upload']) ?>">
    <meta name="ckeditor-image_upload-connection-url" content="<?= Yii::$app->urlManagerBackend->createUrl(['connection/editor-image-upload']) ?>">
    <meta name="ckeditor-images-connection-url" content="<?= Yii::$app->urlManagerBackend->createUrl(['connection/editor-images-get']) ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<div class="nav-wrapper active">
    <a href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>" class="site-logo">
        <img src="<?= Yii::$app->urlManager->createFileUrl('/img/logo.svg') ?>" alt="">
    </a>
    
    <nav class="container-fluid">
        <?= $this->render('_nav'); ?>
    </nav>
</div>

<div id="main-alert">
    <?= $flashes ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
