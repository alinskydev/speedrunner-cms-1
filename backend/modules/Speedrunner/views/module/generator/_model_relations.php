<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

$types = [
    'hasOne' => 'hasOne',
    'hasMany' => 'hasMany',
];

?>

<h4 class="mt-4 mb-3">
    Model relations
</h4>

<table class="table table-relations">
    <thead>
        <tr>
            <th style="width: 2%;"></th>
            <th style="width: 20%;">Name</th>
            <th style="width: 15%;">Type</th>
            <th style="width: 20%;">Model</th>
            <th style="width: 20%;">Condition (from)</th>
            <th style="width: 20%;">Condition (to)</th>
        </tr>
    </thead>
    
    <tbody data-sr-tirgger="sortable">
        <?php foreach ($foreign_keys as $fks_key => $fks) { ?>
            <?php foreach ($fks as $key => $fk) { ?>
                <?php
                    ArrayHelper::remove($fk, 0);
                    $fk = $fks_key == 'internal' ? array_flip($fk) : $fk;
                    $key = Inflector::id2camel($key, '_');
                ?>
                
                <tr>
                    <td>
                        <div class="btn btn-primary table-sorter">
                            <i class="fas fa-arrows-alt"></i>
                        </div>
                    </td>
                    
                    <td>
                        <?= Html::input('text', "GeneratorForm[model_relations][$key][name]", str_replace($table_name, null, $key), [
                            'class' => 'form-control',
                        ]); ?>
                    </td>
                    
                    <td>
                        <?= Html::dropdownList("GeneratorForm[model_relations][$key][type]", null, $types, ['class' => 'form-control']); ?>
                    </td>
                    
                    <td>
                        <?= Html::input('text', "GeneratorForm[model_relations][$key][model]", $key, [
                            'class' => 'form-control',
                            'readonly' => true,
                        ]); ?>
                    </td>
                    
                    <td>
                        <?= Html::input('text', "GeneratorForm[model_relations][$key][cond_from]", array_keys($fk)[0], [
                            'class' => 'form-control',
                            'readonly' => true,
                        ]); ?>
                    </td>
                    
                    <td>
                        <?= Html::input('text', "GeneratorForm[model_relations][$key][cond_to]", array_values($fk)[0], [
                            'class' => 'form-control',
                            'readonly' => true,
                        ]); ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>
