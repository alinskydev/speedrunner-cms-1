<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use yii\bootstrap\Alert;

use backend\modules\Menu\models\Menu;

AppAsset::register($this);

$is_home = Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index';
$curr_url = Yii::$app->request->hostInfo . Yii::$app->request->url;
$langs = Yii::$app->i18n->getLanguages(true);
$menu = Menu::findOne(1)->setJsonAttributes(['url'])->tree();

foreach ($langs as $l) {
    $langs_nav[] = ['label' => strtoupper($l['code']), 'url' => $l['url']];
}

$flashes = Yii::$app->session->getAllFlashes();

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= Yii::$app->settings->site_logo ?>">
    <link rel="canonical" href="<?= $curr_url ?>">
    <meta property="og:site_name" content="<?= Yii::$app->settings->site_name ?>">
    <meta property="og:url" content="<?= $curr_url ?>">
    <meta property="og:locale" content="<?= Yii::$app->language ?>">
    <meta property="og:type" content="website">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'FRONT',
        'brandUrl' => Yii::$app->urlManager->createUrl(['site/index']),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
        ['label' => Yii::t('app', 'Blog'), 'url' => ['/blog/index']],
        ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => Yii::t('app', 'Logout'), 'url' => ['/site/logout']];
    }
    $menuItems[] = ['label' => strtoupper($langs[Yii::$app->language]['code']), 'url' => ['/site/contact'], 'items' => $langs_nav];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    
    <br><br><br><br><br>
    
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        
        <?= $content ?>
        
        <div class="alert-wrapper">
            <?php
                foreach ($flashes as $key => $f) {
                    echo Alert::widget([
                        'options' => [
                            'class' => "alert-$key",
                        ],
                        'body' => $f,
                    ]);
                }
            ?>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
