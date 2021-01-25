<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use frontend\forms\OrderForm;

(new \backend\modules\Seo\services\SeoMetaService($page))->register();

$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div id="<?= Yii::$app->request->isAjax ? 'cart-page-ajax' : 'cart-page' ?>">
    <?php if ($cart) { ?>
        <?php foreach ($cart['products'] as $p) { ?>
            <?= $p['name'] ?>
            <?= Yii::$app->services->image->thumb(ArrayHelper::getValue($p, 'image'), [100, 100], 'resize') ?>
            
            <?= Yii::t('app', 'Price: {price}', [
                'price' => Yii::$app->formatter->asDecimal($p['total_price'])
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
                    'onchange' => '$(this).parents("form").submit();',
                ]); ?>
                <?= Html::button(Html::tag('i', null, ['class' => 'fas fa-plus']), [
                    'data-toggle' => 'cart-quantity-change',
                    'data-type' => 'plus',
                ]) ?>
            </div>
            
            <?= Html::hiddenInput('id', $p['id']); ?>
            <?= Html::endForm(); ?>
        <?php } ?>
        
        <?= Yii::t('app', 'Total price: {price}', [
            'price' => Yii::$app->formatter->asDecimal($cart['total']['price'])
        ]) ?>
        
        <div class="order-form-wrapper">
            <?= $this->render('@frontend/views/order/create', [
                'model' => new OrderForm
            ]); ?>
        </div>
    <?php } else { ?>
        <h2><?= Yii::t('app', 'Your cart is empty now') ?></h2>
    <?php } ?>
</div>
