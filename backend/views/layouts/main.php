<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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
    <meta name="text-editor-params" content="<?= Html::encode(json_encode($text_editor->clientOptions, JSON_UNESCAPED_UNICODE)) ?>">
    
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<div class="theme-side">
    <div class="nav-wrapper-side <?= Yii::$app->session->get('nav') ? 'opened' : null ?>">
        <div class="d-flex">
            <div class="item">
                <?= Html::button(Html::tag('i', null, ['class' => 'fas fa-bars']), [
                    'class' => 'btn btn-link nav-side-toggle',
                    'data-sr-trigger' => 'toggle_session',
                    'data-sr-callback' => "$('.nav-wrapper-side').toggleClass('opened');",
                    'data-sr-url' => Yii::$app->urlManager->createUrl(['session/set']),
                    'data-sr-name' => 'nav',
                    'data-sr-value' => '0',
                ]) ?>
            </div>
            
            <a href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>" class="site-logo">
                <img src="<?= Yii::$app->services->settings->site_logo ?>" class="img-fluid">
            </a>
        </div>
        
        <div class="pt-1 bg-white"></div>
        
        <?= Menu::widget([
            'items' => require '_nav.php',
            'options' => ['class' => 'nav-items mb-1 p-2'],
            'labelTemplate' => '<div class="parent">{label}</div>',
            'submenuTemplate' => '<ul class="items p-2">{items}</ul>',
            'encodeLabels' => false,
            'activateParents' => true,
        ]); ?>
    </div>
    
    <div class="w-100 pl-lg-1">
        <?= $this->render('@backend/views/layouts/_header', ['show_nav_toggler' => false]); ?>
        
        <div class="content">
            <?= $content ?>
        </div>
        
        <div id="alerts-wrapper">
            <?= json_encode(Yii::$app->session->getAllFlashes(), JSON_UNESCAPED_UNICODE) ?>
        </div>
    </div>
</div>

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