<?php

use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Alert;
use yii\widgets\Menu;

AppAsset::register($this);

//-----------------------------------------------------------------------------------

$is_home = Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index';

$menu_items = require '_nav.php';

$flashes = json_encode(Yii::$app->session->getAllFlashes(), JSON_UNESCAPED_UNICODE);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            'items' => $menu_items,
            'options' => ['class' => 'nav-items'],
            'labelTemplate' => '<div class="parent h4 font-weight-normal">{label}</div>',
            'submenuTemplate' => '<ul class="items">{items}</ul>',
            'encodeLabels' => false,
            'activateParents' => true,
        ]); ?>
    </nav>
</div>

<div id="main-alert">
    <?= $flashes ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
