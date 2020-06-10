<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="site-signup">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1><?= Html::encode($this->title) ?></h1>
            
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'confirm_password')->passwordInput() ?>
                <hr>
                
                <?= $form->field($model, 'full_name')->textInput() ?>
                <?= $form->field($model, 'phone')->textInput() ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
