<?php

use yii\helpers\Html;

?>

<h4 class="mt-4 mb-3">
    View relations
</h4>

<table class="table table-relations">
    <thead>
        <tr>
            <th style="width: 2%;"></th>
            <th style="width: 45%;">Model</th>
            <th style="width: 45%;">Variable name</th>
            <th style="width: 3%;"></th>
        </tr>
    </thead>
    
    <tbody data-sr-trigger="sortable">
        <tr class="table-new-relation" data-table="view_relations">
            <td>
                <div class="btn btn-primary table-sorter">
                    <i class="fas fa-arrows-alt"></i>
                </div>
            </td>
            
            <td>
                <?= Html::dropDownList('GeneratorForm[view_relations][__key__][model]', null, $tables, ['class' => 'form-control', 'required' => true]); ?>
            </td>
            
            <td>
                <?= Html::input('text', 'GeneratorForm[view_relations][__key__][var_name]', null, ['class' => 'form-control', 'required' => true]); ?>
            </td>
            
            <td class="text-right">
                <button type="button" class="btn btn-danger btn-remove">
                    <span class="fas fa-times"></span>
                </button>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="view_relations">
                    <i class="fas fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
