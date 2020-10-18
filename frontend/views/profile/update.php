<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Profile');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $this->title ?>

<?php $form = ActiveForm::begin(); ?>
    <?php
        $img = $model->image ? Html::img(Yii::$app->sr->image->thumb($model->image, [300, 300], 'resize'), [
            'class' => 'image-placeholder'
        ]) : null;
        
        echo $form->field($model, 'image', [
            'template' => "{label}$img{input}{hint}{error}"
        ])->fileInput([
            'class' => 'form-control h-auto',
        ]);
    ?>
    
    <?= $form->field($model, 'full_name')->textInput() ?>
    <?= $form->field($model, 'phone')->textInput() ?>
    <?= $form->field($model, 'address')->textArea(['rows' => 5]) ?>
    
    <?= $form->field($model, 'new_password')->passwordInput() ?>
    <?= $form->field($model, 'confirm_password')->passwordInput() ?>
    
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>
<?php ActiveForm::end(); ?>
