<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $this->title ?>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'remember_me')->checkbox() ?>
    
    <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary btn-block']) ?><hr>
<?php ActiveForm::end(); ?>
