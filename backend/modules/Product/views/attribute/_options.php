<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\System\models\SystemLanguage;
use backend\modules\Product\models\ProductAttributeOption;

$options = ArrayHelper::merge($model->options, [new ProductAttributeOption]);

?>

<table class="table table-relations">
    <thead>
        <tr>
            <th></th>
            <th style="width: 100%;"><?= $options[0]->getAttributeLabel('name') ?></th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($options as $o) { ?>
            <?php $o_id = $o->isNewRecord ? '__key__' : $o->id ?>
            
            <tr class="<?= $o->isNewRecord ? 'table-new-relation' : null ?>" data-table="options">
                <td class="table-sorter">
                    <i class="fas fa-arrows-alt"></i>
                </td>
                <td>
                    <?= $form->field($o, 'name', ['template' => '{input}'])->textInput([
                        'name' => "ProductAttribute[options_tmp][$o_id][name]",
                        'class' => 'form-control',
                    ]) ?>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-remove">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td colspan="3">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="options">
                    <i class="fa fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
