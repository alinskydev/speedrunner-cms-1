<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\assets\AppAsset;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Alert;

AppAsset::register($this);

if (Yii::$app->session->get('theme_dark')) {
    $this->registerCssFile('@web/css/theme-dark.css', ['depends' => [AppAsset::className()]]);
}

//-----------------------------------------------------------------------------------

$is_home = Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index';
$user = Yii::$app->user->identity;

$langs = Yii::$app->i18n->getLanguages(true);
$lang_curr = Yii::$app->i18n->getLanguage();

$breadcrumbs = ArrayHelper::getValue($this->params, 'breadcrumbs', []);
$bookmark_add_value = ArrayHelper::getColumn($breadcrumbs, 'label');
$bookmark_add_value = implode(' &rsaquo; ', $bookmark_add_value);

$flashes = Yii::$app->session->getAllFlashes();
$flashes = json_encode($flashes, JSON_UNESCAPED_UNICODE);

\backend\modules\Product\models\ProductCategory::updateAll(['updated' => '2020-09-12 15:00:00']);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="elfinder-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/elfinder-file-upload']) ?>">
    <meta name="ckeditor-image_upload-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/editor-image-upload']) ?>">
    <meta name="ckeditor-images-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/editor-images-get']) ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<header>
    <div class="container-fluid">
        <div class="header-right">
            <div class="item dropdown">
                <button type="button" class="btn btn-link dropdown-toggle flag-wrapper" data-toggle="dropdown">
                    <img src="<?= Yii::$app->sr->image->thumb($lang_curr['image'], [30, 20]) ?>">
                </button>
                
                <div class="dropdown-menu dropdown-menu-right">
                    <?php foreach ($langs as $l) { ?>
                        <a class="dropdown-item flag-wrapper" href="<?= $l['url'] ?>">
                            <img src="<?= Yii::$app->sr->image->thumb($l['image'], [30, 20]) ?>">
                            <?= $l['name'] ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
            
            <div class="item">
                <?= Html::a(
                    Html::tag('i', null, ['class' => 'fas fa-' . (Yii::$app->session->get('theme_dark') ? 'sun' : 'moon')]),
                    ['/session/set'],
                    [
                        'class' => 'btn btn-link',
                        'data-method' => 'post',
                        'data-params' => [
                            'name' => 'theme_dark',
                            'value' => Yii::$app->session->get('theme_dark') ? 0 : 1,
                        ],
                    ]
                ) ?>
            </div>
            
            <div class="item dropdown">
                <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-bookmark"></i>
                </button>
                
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="px-4 py-1">
                        <div class="h5 m-0">
                            <?= Yii::t('app', 'Bookmarks') ?>
                        </div>
                    </div>
                    
                    <div class="dropdown-divider"></div>
                    
                    <div class="px-4">
                        <?php
                            foreach (Yii::$app->session->get('bookmarks', []) as $key => $b) {
                                $buttons[] = Html::a(
                                    Html::tag('i', null, ['class' => 'fas fa-external-link-alt']) . $b,
                                    $key,
                                    ['class' => 'btn btn-primary btn-block btn-icon']
                                );
                                
                                $buttons[] = Html::a(
                                    Html::tag('i', null, ['class' => 'fas fa-times']),
                                    ['/session/remove'],
                                    [
                                        'class' => 'btn btn-danger',
                                        'data-method' => 'post',
                                        'data-params' => [
                                            'name' => 'bookmarks',
                                            'value' => $key,
                                        ],
                                    ]
                                );
                                
                                echo Html::tag('div', implode('', $buttons), ['class' => 'btn-group btn-block text-nowrap']);
                            }
                        ?>
                    </div>
                    
                    <div class="dropdown-divider"></div>
                    
                    <div class="px-4">
                        <?php
                            echo Html::a(
                                Html::tag('i', null, ['class' => 'fas fa-plus-square']) . Yii::t('app', 'Add'),
                                ['/session/set'],
                                [
                                    'class' => 'btn btn-success btn-block btn-icon',
                                    'data-method' => 'post',
                                    'data-params' => [
                                        'name' => 'bookmarks',
                                        'value' => $bookmark_add_value ?: Yii::t('app', 'Link'),
                                    ],
                                ]
                            );
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="item dropdown">
                <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-user-circle"></i>
                </button>
                
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="px-4 pt-2 pb-1">
                        <div class="h5 m-0">
                            <?= $user->full_name ?>
                        </div>
                        <small>
                            <?= $user->roles()[$user->role] ?>
                        </small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item px-4" href="<?= Yii::$app->urlManager->createUrl(['user/user/update', 'id' => $user->id]) ?>">
                        <i class="far fa-id-card">&nbsp;</i>
                        <?= Yii::t('app', 'Profile') ?>
                    </a>
                    <a class="dropdown-item px-4" href="<?= Yii::$app->urlManager->createUrl(['site/logout']) ?>">
                        <i class="fas fa-sign-out-alt">&nbsp;</i>
                        <?= Yii::t('app', 'Logout') ?>
                    </a>
                </div>
            </div>
            
            <div class="item">
                <button type="button" class="btn btn-link nav-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        
        <div class="header-left">
            <?= Breadcrumbs::widget([
                'links' => $breadcrumbs,
                'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => ['/']],
                'options' => ['class' => 'breadcrumbs'],
                'activeItemTemplate' => '<li><span>{link}</span></li>'
            ]) ?>
        </div>
    </div>
</header>

<div class="nav-wrapper">
    <a href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>" class="site-logo">
        <img src="<?= Yii::$app->urlManager->createFileUrl('/img/logo.svg') ?>" alt="">
    </a>
    
    <button class="btn btn-link nav-toggle">
        <i class="fas fa-times"></i>
    </button>
    
    <nav class="container-fluid">
        <?= $this->render('_nav'); ?>
    </nav>
</div>

<div class="content">
    <?= $content ?>
</div>

<div id="main-alert">
    <?= $flashes ?>
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
