<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use alexantr\elfinder\InputFile;
use alexantr\tinymce\TinyMCE;

$attrs = ArrayHelper::index($model->type->attrs, 'name');
$groups = ArrayHelper::merge($model->value, ['__key__' => array_fill_keys(array_keys($attrs), null)]);

?>

<div class="form-group">
    <?= Html::label($model->type->label) ?>
    <?= Html::hiddenInput("Block[$model->id][value]", null); ?>
    
    <table class="table table-relations">
        <tbody data-sr-trigger="sortable">
            <?php foreach ($groups as $key => $group) { ?>
                <tr class="<?= strval($key) == '__key__' ? 'table-new-relation' : null ?>" data-table="<?= "groups-$model->id" ?>">
                    <td>
                        <div class="btn btn-primary table-sorter">
                            <i class="fas fa-arrows-alt"></i>
                        </div>
                    </td>
                    
                    <td class="w-100">
                        <?php foreach ($attrs as $a_key => $a_value) { ?>
                            <div class="form-group mb-3">
                                <?php
                                    echo Html::label($a_value['label']);
                                    
                                    $input_name = "Block[$model->id][value][$key][$a_key]";
                                    $input_value = ArrayHelper::getValue($group, $a_key);
                                    
                                    switch ($a_value['input_type']) {
                                        case 'text_input':
                                            echo Html::textInput(
                                                $input_name,
                                                $input_value,
                                                ['class' => 'form-control']
                                            );
                                            
                                            break;
                                        case 'text_area':
                                            echo Html::textArea(
                                                $input_name,
                                                $input_value,
                                                ['class' => 'form-control', 'rows' => 5]
                                            );
                                            
                                            break;
                                        case 'checkbox':
                                            $checkbox = Html::checkbox(
                                                $input_name,
                                                $input_value,
                                                [
                                                    'uncheck' => 0,
                                                    'id' => "block-$model->id-$key-$a_key",
                                                    'class' => 'custom-control-input',
                                                ]
                                            );
                                            
                                            $checkbox .= Html::label(null, "block-$model->id-$key-$a_key", ['class' => 'custom-control-label']);
                                            echo Html::tag('div', $checkbox, ['class' => 'custom-control custom-switch float-left']);
                                            
                                            break;
                                        case 'file_manager':
                                            echo Html::tag(
                                                'div',
                                                InputFile::widget([
                                                    'id' => "elfinder-$key",
                                                    'name' => $input_name,
                                                    'value' => $input_value,
                                                ]),
                                                ['data-sr-trigger' => 'file_manager']
                                            );
                                            
                                            break;
                                        case 'text_editor':
                                            echo TinyMCE::widget([
                                                'name' => $input_name,
                                                'value' => $input_value,
                                                'id' => "redactor-$key",
                                                'options' => [
                                                    'data-sr-trigger' => 'text_editor',
                                                ]
                                            ]);
                                            
                                            break;
                                    }
                                ?>
                            </div>
                        <?php } ?>
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
                    <button type="button" class="btn btn-success btn-block btn-add" data-table="<?= "groups-$model->id" ?>">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
