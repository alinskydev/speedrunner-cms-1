<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;

use backend\modules\Menu\models\Menu;

AppAsset::register($this);

$is_home = Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index';
$curr_url = Yii::$app->request->hostInfo . Yii::$app->request->url;

$user = Yii::$app->user->identity;
$langs = Yii::$app->services->i18n::$languages;
$menu = Menu::findOne(1)->setJsonAttributes(['name', 'url'])->tree();

$flashes = Yii::$app->session->getAllFlashes();

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="<?= $curr_url ?>">
    <link rel="icon" href="<?= Yii::$app->services->settings->site_favicon ?>">
    <meta property="og:site_name" content="<?= Yii::$app->services->settings->site_name ?>">
    <meta property="og:url" content="<?= $curr_url ?>">
    <meta property="og:locale" content="<?= Yii::$app->language ?>">
    <meta property="og:type" content="website">
    <?= Html::csrfMetaTags() ?>
    <title><?= $this->title ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<?php foreach ($langs as $l) { ?>
    <?= $l['code'] ?>
    <?= $l['url'] ?>
<?php } ?>

<?= Html::a(
    Html::tag('i', '&nbsp;', ['class' => 'fas fa-sign-out-alt']) . Yii::t('app', 'Logout'),
    ['/auth/logout'],
    ['class' => 'dropdown-item px-3', 'data-method' => 'POST']
) ?>

<?= Breadcrumbs::widget([
    'links' => $this->params['breadcrumbs'] ?? [],
    'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => ['/']],
    'options' => ['class' => 'breadcrumbs'],
    'itemTemplate' => '<li>{link}</li>',
    'activeItemTemplate' => '<li class="active">{link}</li>',
]) ?>

<?= $content ?>

<div class="alert-wrapper">
    <?php print_r($flashes) ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
