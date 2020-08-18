<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'action' => ['order/create'],
    'options' => [
        'id' => 'order-form',
        'class' => 'checkout-form',
        'data-toggle' => 'ajax-form',
        'data-el' => '.order-form-wrapper',
    ],
]); ?>

<?= $form->field($model, 'full_name')->textInput() ?>
<?= $form->field($model, 'email')->textInput() ?>
<?= $form->field($model, 'phone')->textInput() ?>
<?= $form->field($model, 'address')->textArea(['rows' => 5]) ?>
<?= $form->field($model, 'delivery_type')->dropDownList($model->order->deliveryTypes()) ?>

<?php ActiveForm::end(); ?>
