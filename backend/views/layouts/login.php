<?php

use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Alert;

AppAsset::register($this);

//-----------------------------------------------------------------------------------

$flashes = Yii::$app->session->getAllFlashes();
$flashes = json_encode($flashes, JSON_UNESCAPED_UNICODE);

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

<div class="content">
    <?= $content ?>
</div>

<div id="main-alert">
    <?= $flashes ?>
</div>

<div class="login-bg"></div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
