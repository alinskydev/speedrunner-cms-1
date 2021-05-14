<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\System\models\SystemLanguage;
use backend\modules\Product\models\ProductSpecificationOption;

$options = ArrayHelper::merge($model->options, [new ProductSpecificationOption]);

?>

<table class="table table-relations">
    <thead>
        <tr>
            <th style="width: 50px;"></th>
            <th><?= $options[0]->getAttributeLabel('name') ?></th>
            <th style="width: 50px;"></th>
        </tr>
    </thead>
    
    <tbody data-sr-tirgger="sortable">
        <?php foreach ($options as $o) { ?>
            <?php $o_id = $o->isNewRecord ? '__key__' : $o->id ?>
            
            <tr class="<?= $o->isNewRecord ? 'table-new-relation' : null ?>" data-table="options">
                <td>
                    <div class="btn btn-primary table-sorter">
                        <i class="fas fa-arrows-alt"></i>
                    </div>
                </td>
                
                <td>
                    <?= $form->field($o, 'name', ['template' => '{input}'])->textInput([
                        'name' => "ProductSpecification[options_tmp][$o_id][name]",
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
            <td colspan="3">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="options">
                    <i class="fas fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
