<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Reset password');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $this->title ?>

<?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'confirm_password')->passwordInput() ?>
    
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
