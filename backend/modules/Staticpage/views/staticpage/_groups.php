<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use alexantr\elfinder\InputFile;
use vova07\imperavi\Widget;

$attrs = ArrayHelper::index($model->attrs, 'name');

foreach ($attrs as $a) {
    $name = $a['name'];
    $new_group['__key__'][$name] = null;
}

$groups = ArrayHelper::merge($model->value, $new_group);

?>

<div class="form-group">
    <?= Html::label($model->label) ?>
    <?= Html::hiddenInput("StaticpageBlock[$model->id][value]", null); ?>
    
    <table class="table table-relations">
        <tbody data-toggle="sortable">
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
                                <label>
                                    <?= $a_value['label'] ?>
                                </label>
                                
                                <?php
                                    $input_name = "StaticpageBlock[$model->id][value][$key][$a_key]";
                                    $input_value = ArrayHelper::getValue($group, $a_key);
                                    
                                    switch ($a_value['type']) {
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
                                                    'id' => "staticpageblock-$key-$a_key",
                                                    'class' => 'custom-control-input',
                                                ]
                                            );
                                            
                                            $checkbox .= Html::label(null, "staticpageblock-$key-$a_key", ['class' => 'custom-control-label']);
                                            echo Html::tag('div', $checkbox, ['class' => 'custom-control custom-switch float-left']);
                                            
                                            break;
                                        case 'imperavi':
                                            echo Widget::widget([
                                                'name' => $input_name,
                                                'value' => $input_value,
                                                'id' => "redactor-$key",
                                                'options' => [
                                                    'data-toggle' => 'imperavi',
                                                ]
                                            ]);
                                            
                                            break;
                                        case 'elfinder':
                                            echo Html::tag(
                                                'div',
                                                InputFile::widget([
                                                    'id' => "elfinder-$key",
                                                    'name' => $input_name,
                                                    'value' => $input_value,
                                                ]),
                                                ['data-toggle' => 'elfinder']
                                            );
                                            
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
