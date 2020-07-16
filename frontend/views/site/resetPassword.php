<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Reset password');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="site-reset-password">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1><?= $this->title ?></h1>
            
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'confirm_password')->passwordInput() ?>
                
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
