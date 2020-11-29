<?php

use yii\widgets\Menu;

?>

<?= $this->render('@backend/views/layouts/_header', ['show_nav_toggler' => true]); ?>

<div class="nav-wrapper-full">
    <a href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>" class="site-logo">
        <img src$="<?= Yii::getAlias('@web/img/logo.svg') ?>" alt="">
    </a>
    
    <button class="btn btn-link nav-full-toggle">
        <i class="fas fa-times"></i>
    </button>
    
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

<div class="content">
    <?= $content ?>
</div>

<div id="main-alert">
    <?= $flashes ?>
</div>
