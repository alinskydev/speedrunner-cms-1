<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('app', 'Order №{id}', ['id' => $model->id]);

$attrs = ['full_name', 'phone', 'email', 'address', 'created'];

?>

<?= $model->getAttributeLabel('status'); ?>:
<?= ArrayHelper::getValue($model->statuses(), "$model->status.label"); ?>

<?= $model->getAttributeLabel('delivery_type'); ?>:
<?= ArrayHelper::getValue($model->deliveryTypes(), "$model->delivery_type.label"); ?>

<?= $model->getAttributeLabel('payment_type'); ?>:
<?= ArrayHelper::getValue($model->paymentTypes(), "$model->payment_type.label"); ?>

<?php foreach ($attrs as $a) { ?>
    <?= $model->getAttributeLabel($a) . ': ' . $model->{$a}; ?>
<?php } ?>

<?php foreach ($model->products as $key => $p) { ?>
    <?php $product_mdl = $p->product ?>
    
    <?= $p->quantity ?>
    
    <?= Yii::t('app', 'Price: {price}', [
        'price' => Yii::$app->formatter->asDecimal($p->total_price)
    ]) ?>
<?php } ?>

<?= Yii::t('app', 'Products price: {price} сум', [
    'price' => Yii::$app->formatter->asDecimal($model->total_price)
]) ?>

<?= Yii::t('app', 'Delivery price: {price} сум', [
    'price' => Yii::$app->formatter->asDecimal($model->delivery_price)
]) ?>

<?= Yii::t('app', 'Total price: {price} сум', [
    'price' => Yii::$app->formatter->asDecimal($model->service->realTotalPrice())
]) ?>
