<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\AssetManager;
use backend\assets\AppAsset;

AppAsset::register($this);
(new \alexantr\tinymce\TinyMCE(['name' => false]))->run();

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#067a7d">
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web/favicon.svg') ?>">
    
    <meta name="file-manager-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/elfinder-input']) ?>">
    <meta name="text-editor-base-url" content="<?= (new AssetManager())->getBundle('\alexantr\tinymce\WidgetAsset')->baseUrl . '/' ?>">
    <meta name="text-editor-file-picker-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/tinymce']) ?>">
    <meta name="text-editor-image-upload-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/tinymce-image-upload']) ?>">
    
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<?= $this->render('@backend/views/layouts/themes/' . (Yii::$app->user->identity->design_theme ?? 'nav_full'), [
    'content' => $content,
    'menu_items' => require '_nav.php',
    'flashes' => json_encode(Yii::$app->session->getAllFlashes(), JSON_UNESCAPED_UNICODE),
]); ?>

<?= $this->render('@backend/views/layouts/design/style'); ?>

<div class="modal fade" id="main-modal">
    <div class="modal-dialog"></div>
</div>

<div id="ajax-mask">
    <div class="ajax-mask-wrapper">
        <div class="line"></div>
        <div class="line"></div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>