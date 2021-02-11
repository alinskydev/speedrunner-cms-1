<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\Order\models\OrderProduct;

$relations = ArrayHelper::merge($model->products, [new OrderProduct]);
$is_block_disabled = !$model->isNewRecord && ArrayHelper::getValue($model->statuses(), "{$model->oldAttributes['status']}.save_action") == 'minus';

?>

<table class="table table-relations <?= $is_block_disabled ? 'disabled-block' : null ?>">
    <thead>
        <tr>
            <th style="width: 50px;"></th>
            <th><?= $relations[0]->getAttributeLabel('product_id') ?></th>
            <th><?= $relations[0]->getAttributeLabel('quantity') ?></th>
            <th style="width: 50px;"></th>
        </tr>
    </thead>
    
    <tbody data-toggle="sortable">
        <?php foreach ($relations as $value) { ?>
            <?php $value_id = $value->isNewRecord ? '__key__' : $value->id ?>
            
            <tr class="<?= $value->isNewRecord ? 'table-new-relation' : null ?>" data-table="products">
                <td>
                    <div class="btn btn-primary table-sorter">
                        <i class="fas fa-arrows-alt"></i>
                    </div>
                </td>
                
                <td>
                    <?php
                        echo $form->field($value, 'product_id', [
                            'template' => '{input}',
                            'enableClientValidation' => false,
                        ])->dropDownList(
                            [$value->product_id => ArrayHelper::getValue($value, 'product.name')],
                            [
                                'name' => "Order[products_tmp][$value_id][product_id]",
                                'id' => "select2-products-$value_id",
                                'data-toggle' => 'select2-ajax',
                                'data-action' => Yii::$app->urlManager->createUrl(['items-list/products']),
                            ]
                        );
                    ?>
                </td>
                
                <td>
                    <?= $form->field($value, 'quantity', ['template' => '{input}'])->textInput([
                        'name' => "Order[products_tmp][$value_id][quantity]",
                    ]) ?>
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
