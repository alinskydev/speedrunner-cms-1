<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Profile');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="site-login">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1><?= $this->title ?></h1>
            
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'username')->textInput() ?>
                <?= $form->field($model, 'full_name')->textInput() ?>
                <?= $form->field($model, 'phone')->textInput() ?>
                <?= $form->field($model, 'address')->textArea(['rows' => 5]) ?><hr>
                <?= $form->field($model, 'new_password')->passwordInput() ?>
                <?= $form->field($model, 'confirm_password')->passwordInput() ?>
                
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
