<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $this->title ?>

<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'confirm_password')->passwordInput() ?>
    
    <?= $form->field($model, 'full_name')->textInput() ?>
    <?= $form->field($model, 'phone')->textInput() ?>
    
    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
<?php ActiveForm::end(); ?>
