<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Request reset password');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $this->title ?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    
    <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary btn-block']) ?>
<?php ActiveForm::end(); ?>
