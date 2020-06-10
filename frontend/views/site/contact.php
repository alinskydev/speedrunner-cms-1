<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::errorSummary($model, ['encode' => false]) ?>
    
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => true]) ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'phone') ?>
                <?= $form->field($model, 'message')->textarea(['rows' => 6, 'placeholder' => true]) ?>
                <?= $form->field($model, 'verify_code')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>
                
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
