<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {username}', ['username' => $model->username]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
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
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-profile">
                    <?= Yii::t('app', 'Profile') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-design">
                    <?= Yii::t('app', 'Design') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-information" class="tab-pane active">
                <?= $form->field($model, 'username')->textInput() ?>
                <?= $form->field($model, 'role')->dropDownList(ArrayHelper::getColumn($model->roles(), 'label')) ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'new_password', ['enableClientValidation' => false])->passwordInput() ?>
            </div>
            
            <div id="tab-profile" class="tab-pane fade">
                <?php
                    $img = $model->image ? Html::img(Yii::$app->services->image->thumb($model->image, [300, 300], 'resize'), [
                        'class' => 'img-fluid d-block my-3 image-placeholder'
                    ]) : null;
                    
                    echo $form->field($model, 'image', [
                        'template' => "{label}$img{input}{hint}{error}"
                    ])->fileInput([
                        'class' => 'form-control h-auto',
                    ]);
                ?>
                
                <?= $form->field($model, 'full_name')->textInput() ?>
                <?= $form->field($model, 'phone')->textInput() ?>
                <?= $form->field($model, 'address')->textArea(['rows' => 5]) ?>
            </div>
            
            <div id="tab-design" class="tab-pane fade">
                <?= $form->field($model, 'design_theme')->dropDownList(ArrayHelper::getColumn($model->designThemes(), 'label')) ?>
                <?= $form->field($model, 'design_font')->dropDownList(ArrayHelper::getColumn($model->designFonts(), 'label')) ?>
                <?= $form->field($model, 'design_border_radius')->textInput() ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
