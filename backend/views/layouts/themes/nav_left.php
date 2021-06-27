<?php

use yii\helpers\Html;
use backend\widgets\layout\Menu;

?>

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
            'items' => $menu_items,
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
            <?= $flashes ?>
        </div>
    </div>
</div>
