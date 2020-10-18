<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product specifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'update-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->sr->html->updateButtons(['save_reload', 'save']) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    <?= Yii::t('app', 'Information') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-options">
                    <?= Yii::t('app', 'Options') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-information" class="tab-pane active">
                <?= $form->field($model, 'name')->textInput() ?>
                
                <?= $form->field($model, 'use_filter', [
                    'checkboxTemplate' => Yii::$app->params['switcher_template'],
                ])->checkbox([
                    'class' => 'custom-control-input'
                ])->label(null, [
                    'class' => 'custom-control-label'
                ]) ?>
                
                <?= $form->field($model, 'use_compare', [
                    'checkboxTemplate' => Yii::$app->params['switcher_template'],
                ])->checkbox([
                    'class' => 'custom-control-input'
                ])->label(null, [
                    'class' => 'custom-control-label'
                ]) ?>
                
                <?= $form->field($model, 'use_detail', [
                    'checkboxTemplate' => Yii::$app->params['switcher_template'],
                ])->checkbox([
                    'class' => 'custom-control-input'
                ])->label(null, [
                    'class' => 'custom-control-label'
                ]) ?>
            </div>
            
            <div id="tab-options" class="tab-pane fade">
                <?= $this->render('_options', [
                    'model' => $model,
                    'form' => $form,
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
