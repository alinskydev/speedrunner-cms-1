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
