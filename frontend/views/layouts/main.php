<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use yii\bootstrap\Alert;

use backend\modules\Menu\models\Menu;

AppAsset::register($this);

$is_home = Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index';
$curr_url = Yii::$app->request->hostInfo . Yii::$app->request->url;

$user = Yii::$app->user->identity;
$langs = Yii::$app->sr->translation->languages();
$menu = Menu::findOne(1)->setJsonAttributes(['url'])->tree();

$flashes = Yii::$app->session->getAllFlashes();

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= Yii::$app->settings->site_favicon ?>">
    <link rel="canonical" href="<?= $curr_url ?>">
    <meta property="og:site_name" content="<?= Yii::$app->settings->site_name ?>">
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

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => ['/']],
    'options' => ['class' => 'breadcrumbs'],
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

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
