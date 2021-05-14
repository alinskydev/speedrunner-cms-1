<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\Order\models\OrderProduct;

$relations = ArrayHelper::merge($model->products, [new OrderProduct]);
$is_block_disabled = !$model->isNewRecord && $model->status != 'new';

?>

<table class="table table-relations <?= $is_block_disabled ? 'disabled-block' : null ?>">
    <thead>
        <tr>
            <th style="width: 50px;"></th>
            <th><?= $relations[0]->getAttributeLabel('product_id') ?></th>
            <th><?= $relations[0]->getAttributeLabel('total_price') ?></th>
            <th style="width: 50px;"></th>
        </tr>
    </thead>
    
    <tbody data-sr-tirgger="sortable">
        <?php foreach ($relations as $value) { ?>
            <?php $value_id = $value->isNewRecord ? '__key__' : $value->id ?>
            
            <tr class="<?= $value->isNewRecord ? 'table-new-relation' : null ?>" data-table="products">
                <td>
                    <div class="btn btn-primary table-sorter">
                        <i class="fas fa-arrows-alt"></i>
                    </div>
                </td>
                
                <td>
                    <?php if ($is_block_disabled) { ?>
                        <?= $form->field($value, 'product_id', [
                            'options' => ['class' => 'form-group mb-3'],
                        ])->textInput([
                            'value' => ArrayHelper::getValue($value, 'product_json.name'),
                        ]) ?>
                        
                        <?php if ($variation_name = ArrayHelper::getValue($value, 'product_json.variation.name')) { ?>
                            <?= $form->field($value, 'variation_id')->textInput([
                                'value' => $variation_name,
                            ]) ?>
                        <?php } ?>
                    <?php } else { ?>
                        <?= $form->field($value, 'product_id', [
                            'enableClientValidation' => false,
                            'options' => ['class' => 'form-group mb-3'],
                        ])->dropDownList(
                            [$value->product_id => ArrayHelper::getValue($value, 'product.name')],
                            [
                                'name' => "Order[products_tmp][$value_id][product_id]",
                                'id' => "select2-products-$value_id",
                                'disabled' => $is_block_disabled,
                                'data-sr-trigger' => 'select2-ajax',
                                'data-url' => Yii::$app->urlManager->createUrl(['items-list/products']),
                                
                                'data-variation-toggle' => true,
                                'data-variation-action' => Yii::$app->urlManager->createUrl(['product/product/variations']),
                                'data-variation-id' => $value->variation_id,
                                'data-variation-name' => "Order[products_tmp][$value_id][variation_id]",
                            ]
                        ); ?>
                        
                        <div class="order-products-variation-wrapper"></div>
                    <?php } ?>
                    
                    <?= $form->field($value, 'quantity', [
                        'options' => ['class' => 'mt-3'],
                    ])->textInput([
                        'name' => "Order[products_tmp][$value_id][quantity]",
                    ]) ?>
                </td>
                
                <td>
                    <?= $form->field($value, 'price', ['options' => ['class' => 'form-group mb-3']])->textInput(['readonly' => true]) ?>
                    <?= $form->field($value, 'discount', ['options' => ['class' => 'form-group mb-3']])->textInput(['readonly' => true]) ?>
                    <?= $form->field($value, 'total_price')->textInput(['readonly' => true]) ?>
                </td>
                
                <td>
                    <button type="button" class="btn btn-danger btn-remove">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td colspan="4">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="products">
                    <i class="fas fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let el, action, sendData;
        
        $(document).on('change', '[data-variation-toggle]', function() {
            el = $(this);
            action = el.data('variation-action');
            
            sendData = {
                id: el.val(),
                variation_id: el.data('variation-id'),
                name: el.data('variation-name'),
            };
            
            $.get(action, sendData, (data) => {
                $($(this).closest('tr').find('.order-products-variation-wrapper')).html(data);
            });
        });
        
        <?php if (!$is_block_disabled) { ?>
            $('[data-variation-toggle]').trigger('change');
        <?php } ?>
    });
</script>
