<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Contact');

?>

<div class="site-contact">
    <h1><?= $this->title ?></h1>
    <?= Html::errorSummary($model, ['encode' => false]) ?>
    
    <div class="row">
        <div class="col-md-6">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'phone')->textInput() ?>
                <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
                
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary btn-block']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
