<?php

use yii\helpers\Html;

$this->title = 'Speedrunner';
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <?php foreach ($action_types as $key => $action_type) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= !$key ? 'active' : null ?>" data-toggle="pill" href="#tab-<?= $key ?>">
                        <?= $action_type['label'] ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow px-3 py-1">
            <?php foreach ($action_types as $key => $action_type) { ?>
                <div id="tab-<?= $key ?>" class="tab-pane <?= !$key ? 'active' : 'fade' ?>">
                    <div class="row">
                        <?php foreach ($action_type['actions'] as $key => $a) { ?>
                            <div class="col-md-3 p-2">
                                <a href="<?= Yii::$app->urlManager->createUrl($a['url']) ?>" class="card text-decoration-none">
                                    <div class="card-header bg-<?= $a['bg_class'] ?> text-white text-center">
                                        <?= $a['label'] ?>
                                    </div>
                                    
                                    <div class="card-body text-<?= $a['bg_class'] ?> text-center p-5" style="font-size: 100px;">
                                        <i class="<?= $a['icon_class'] ?>"></i>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
