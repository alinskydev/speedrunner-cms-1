<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>

<?php if (isset($cart['products'])) { ?>
    <?php foreach ($cart['products'] as $p) { ?>
        <?= $p['name'] ?>
        <?= Yii::$app->services->image->thumb(ArrayHelper::getValue($p, 'image'), [100, 100]) ?>
        
        <?= Yii::$app->services->formatter->asPrice($p['total_price']) ?>
        
        <?= Yii::t('app', 'Quantity: {quantity}', [
            'quantity' => $p['total_quantity']
        ]) ?>
        
        <?= Html::beginForm(['cart/change'], 'post', [
            'data-toggle' => 'cart-change-form',
        ]); ?>
        
        <div class="cart-quantity-wrapper">
            <?= Html::button(Html::tag('i', null, ['class' => 'fas fa-minus']), [
                'data-toggle' => 'cart-quantity-change',
                'data-type' => 'minus',
            ]) ?>
            <?= Html::textInput('quantity', $p['total_quantity'], [
                'onchange' => '$(this).closest("form").submit();',
            ]); ?>
            <?= Html::button(Html::tag('i', null, ['class' => 'fas fa-plus']), [
                'data-toggle' => 'cart-quantity-change',
                'data-type' => 'plus',
            ]) ?>
        </div>
        
        <?= Html::hiddenInput('id', $p['id']); ?>
        <?= Html::endForm(); ?>
    <?php } ?>
    
    <?= Yii::$app->services->formatter->asPrice($cart['total']['price']) ?>
<?php } else { ?>
    <h2><?= Yii::t('app', 'Your cart is empty now') ?></h2>
<?php } ?>
