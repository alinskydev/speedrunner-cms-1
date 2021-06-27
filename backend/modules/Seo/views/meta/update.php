<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'SEO meta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'SEO'), 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'update-form'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->helpers->html->saveButtons(['save']) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-seo-meta">
                    <?= Yii::t('app', 'SEO meta') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-seo-meta" class="tab-pane active">
                <?= $this->render('@backend/modules/Seo/views/meta/meta', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
