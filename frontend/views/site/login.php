<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="site-login">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1><?= Html::encode($this->title) ?></h1>
            
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                
                <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary btn-block']) ?><hr>
                <?= Html::a(Yii::t('app', 'Reset password'), ['site/request-password-reset'], ['class' => 'btn btn-success btn-block']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
