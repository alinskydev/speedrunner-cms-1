<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Sign in');

?>

<div class="login-wrapper main-shadow">
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
    
    <div class="card">
        <div class="card-header bg-primary text-center py-4">
            <img src="<?= Yii::$app->urlManager->createFileUrl('/img/logo.svg') ?>" class="logo">
        </div>
        
        <div class="card-body">
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]); ?>
            <?= $form->field($model, 'password')->passwordInput(); ?>
            
            <?= $form->field($model, 'remember_me', [
                'checkboxTemplate' => Yii::$app->params['checkbox_template'],
            ])->checkbox([
                'class' => 'custom-control-input'
            ])->label(null, [
                'class' => 'custom-control-label'
            ]) ?>
        </div>
        
        <div class="card-footer">
            <?= Html::submitButton(
                Yii::t('app', 'Sign in'),
                ['class' => 'btn btn-primary btn-block']
            ) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>
