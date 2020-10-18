<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\assets\AppAsset;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

//-----------------------------------------------------------------------------------

$breadcrumbs = ArrayHelper::getValue($this->params, 'breadcrumbs', []);

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

<header>
    <div class="container-fluid">
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

<div class="content">
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
