<?php

use yii\helpers\Html;
use yii\web\AssetManager;
use backend\assets\AppAsset;
use backend\widgets\layout\Menu;

AppAsset::register($this);

$text_editor = Yii::createObject(['class' => 'alexantr\tinymce\TinyMCE', 'name' => false]);
$text_editor->run();

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#067a7d">
    <link rel="icon" href="<?= Yii::getAlias('@web/favicon.svg') ?>">
    
    <meta name="file-manager-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/elfinder-input']) ?>">
    <meta name="text-editor-base-url" content="<?= (new AssetManager())->getBundle('\alexantr\tinymce\WidgetAsset')->baseUrl . '/' ?>">
    <meta name="text-editor-file-picker-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/tinymce']) ?>">
    <meta name="text-editor-image-upload-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/tinymce-image-upload']) ?>">
    <meta name="text-editor-params" content="<?= Html::encode(json_encode($text_editor->clientOptions, JSON_UNESCAPED_UNICODE)) ?>">
    
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

<div id="alerts-wrapper">
    <?= json_encode(Yii::$app->session->getAllFlashes(), JSON_UNESCAPED_UNICODE) ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
