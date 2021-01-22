<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('yii2mod.rbac', 'RBAC'), 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii2mod.rbac', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'edit-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::submitButton(
        Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>
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
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'className')->textInput() ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
