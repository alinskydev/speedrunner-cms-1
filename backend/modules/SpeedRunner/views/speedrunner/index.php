<?php

use yii\helpers\Html;

$this->title = 'SpeedRunner';
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
</h2>

<div class="px-2">
    <div class="row">
        <?php foreach ($actions as $key => $a) { ?>
            <div class="col-md p-2">
                <a href="<?= Yii::$app->urlManager->createUrl($a['url']) ?>" class="card text-decoration-none">
                    <div class="card-header bg-<?= $a['bg_class'] ?> text-white text-center">
                        <?= Yii::t('app', $a['label']) ?>
                    </div>
                    
                    <div class="card-body text-<?= $a['bg_class'] ?> text-center p-5" style="font-size: 100px;">
                        <i class="<?= $a['icon_class'] ?>"></i>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
