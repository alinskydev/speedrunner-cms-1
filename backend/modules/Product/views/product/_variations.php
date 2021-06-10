<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\ProductVariation;

$relations = ArrayHelper::merge($model->variations, [new ProductVariation]);

?>

<table class="table table-relations">
    <thead>
        <tr>
            <th style="width: 50px;"></th>
            <th><?= $relations[0]->getAttributeLabel('name') . ' & ' . $relations[0]->getAttributeLabel('sku') ?></th>
            <th><?= $relations[0]->getAttributeLabel('price') . ' & ' . $relations[0]->getAttributeLabel('discount') ?></th>
            <th><?= $relations[0]->getAttributeLabel('quantity') ?></th>
            <th style="width: 50px;"></th>
            <th style="width: 50px;"></th>
        </tr>
    </thead>
    
    <tbody data-sr-trigger="sortable">
        <?php foreach ($relations as $value) { ?>
            <?php $value_id = $value->isNewRecord ? '__key__' : $value->id ?>
            
            <tr class="<?= $value->isNewRecord ? 'table-new-relation' : null ?>" data-table="variations">
                <td>
                    <div class="btn btn-primary table-sorter">
                        <i class="fas fa-arrows-alt"></i>
                    </div>
                </td>
                
                <td>
                    <?= $form->field($value, 'name', [
                        'template' => '{label}{input}',
                        'options' => ['class' => 'form-group mb-3'],
                    ])->textInput([
                        'name' => "Product[variations_tmp][$value_id][name]",
                    ]) ?>
                    
                    <?= $form->field($value, 'sku', [
                        'template' => '{label}{input}',
                    ])->textInput([
                        'name' => "Product[variations_tmp][$value_id][sku]",
                    ]) ?>
                </td>
                
                <td>
                    <?= $form->field($value, 'price', [
                        'template' => '{label}{input}',
                        'options' => ['class' => 'form-group mb-3'],
                    ])->textInput([
                        'name' => "Product[variations_tmp][$value_id][price]",
                    ]) ?>
                    
                    <?= $form->field($value, 'discount', [
                        'template' => '{label}{input}',
                    ])->textInput([
                        'name' => "Product[variations_tmp][$value_id][discount]",
                    ]) ?>
                </td>
                
                <td colspan="<?= $value->isNewRecord ? 2 : 1 ?>">
                    <?= $form->field($value, 'quantity', [
                        'template' => '{label}{input}',
                    ])->textInput([
                        'name' => "Product[variations_tmp][$value_id][quantity]",
                    ]) ?>
                </td>
                
                <?php if (!$value->isNewRecord) { ?>
                    <td>
                        <?= Html::button(
                            Html::tag('i', null, ['class' => 'fas fa-images']),
                            [
                                'class' => 'btn btn-primary',
                                'data-sr-trigger' => 'ajax-button',
                                'data-sr-url' => Yii::$app->urlManager->createUrl(['product/variation/update', 'id' => $value->id]),
                                'data-sr-wrapper' => '#main-modal',
                                'data-sr-callback' => '$("#main-modal").modal()',
                            ]
                        ) ?>
                    </td>
                <?php } ?>
                
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
            <td colspan="6">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="variations">
                    <i class="fas fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
