<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('app', 'Order №{id}', ['id' => $model->id]);

?>

<?= $model->getAttributeLabel('full_name') . ': ' . $model->full_name; ?>
<br>

<?= $model->getAttributeLabel('status'); ?>:
<?= ArrayHelper::getValue($model->enums->statuses(), "$model->status.label"); ?>
<br>

<?= $model->getAttributeLabel('delivery_type'); ?>:
<?= ArrayHelper::getValue($model->enums->deliveryTypes(), "$model->delivery_type.label"); ?>
<br>

<?= $model->getAttributeLabel('payment_type'); ?>:
<?= ArrayHelper::getValue($model->enums->paymentTypes(), "$model->payment_type.label"); ?>
<br>

<?php foreach ($model->products as $key => $p) { ?>
    <?= $p->quantity ?>
    
    <?= Yii::$app->services->formatter->asPrice($p->total_price) ?>
<?php } ?>

Total
<?= Yii::$app->services->formatter->asPrice($model->total_price) ?>

Delivery
<?= Yii::$app->services->formatter->asPrice($model->delivery_price) ?>

Checkout
<?= Yii::$app->services->formatter->asPrice($model->checkout_price) ?>
