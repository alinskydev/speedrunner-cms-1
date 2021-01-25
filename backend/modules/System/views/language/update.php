<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use zxbodya\yii2\elfinder\ElFinderInput;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'update-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->services->html->updateButtons(['save_reload', 'save']) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    <?= Yii::t('app', 'Information') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-information" class="tab-pane active">
                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'code')->textInput() ?>
                
                <?= $form->field($model, 'is_active', [
                    'checkboxTemplate' => Yii::$app->params['switcher_template'],
                ])->checkbox([
                    'class' => 'custom-control-input'
                ])->label(null, [
                    'class' => 'custom-control-label'
                ]) ?>
                
                <?= $form->field($model, 'is_main', [
                    'checkboxTemplate' => Yii::$app->params['switcher_template'],
                ])->checkbox([
                    'class' => 'custom-control-input'
                ])->label(null, [
                    'class' => 'custom-control-label'
                ]) ?>
                
                <?= $form->field($model, 'image')->widget(ElFinderInput::className(), [
                    'connectorRoute' => '/connection/elfinder-file-upload',
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
