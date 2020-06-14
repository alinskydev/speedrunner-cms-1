<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;

$attrs = ArrayHelper::index($model->type->attrs, 'name');

foreach ($attrs as $a) {
    $name = $a['name'];
    $new_group['__key__'][$name] = null;
}

$groups = ArrayHelper::merge($model->value, $new_group);

?>

<div class="form-group">
    <?= Html::label($model->type->label) ?>
    <?= Html::hiddenInput("Block[$model->id][value]", null); ?>
    
    <table class="table table-relations">
        <tbody>
            <?php foreach ($groups as $key => $group) { ?>
                <tr class="<?= $key == '__key__' ? 'table-new-relation' : null ?>" data-table="<?= "groups-$model->id" ?>">
                    <td class="table-sorter">
                        <i class="fas fa-arrows-alt"></i>
                    </td>
                    
                    <td style="width: 100%;">
                        <?php foreach ($attrs as $a_key => $a_value) { ?>
                            <div class="form-group mb-3">
                                <label>
                                    <?= Yii::t('app', $a_value['label']) ?>
                                </label>
                                
                                <?php
                                    $input_name = "Block[$model->id][value][$key][$a_key]";
                                    $input_value = ArrayHelper::getValue($group, $a_key);
                                    
                                    switch ($a_value['type']) {
                                        case 'textInput':
                                            echo Html::textInput(
                                                $input_name,
                                                $input_value,
                                                ['class' => 'form-control']
                                            );
                                            
                                            break;
                                        case 'textArea':
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
                                                    'id' => "block-$key-$a_key",
                                                    'class' => 'custom-control-input',
                                                ]
                                            );
                                            
                                            $checkbox .= Html::label(null, "block-$key-$a_key", ['class' => 'custom-control-label']);
                                            echo Html::tag('div', $checkbox, ['class' => 'custom-control custom-switch float-left']);
                                            
                                            break;
                                        case 'CKEditor':
                                            echo Widget::widget([
                                                'name' => $input_name,
                                                'value' => $input_value,
                                                'id' => "redactor-$key",
                                                'settings' => [
                                                    'imageUpload' => Yii::$app->urlManager->createUrl('connection/editor-image-upload'),
                                                    'imageManagerJson' => Yii::$app->urlManager->createUrl('connection/editor-images'),
                                                ],
                                            ]);
                                            
                                            break;
                                        case 'ElFinder':
                                            echo ElFinderInput::widget([
                                                'connectorRoute' => '/connection/elfinder-file-upload',
                                                'name' => $input_name,
                                                'value' => $input_value,
                                                'id' => "elfinder-$key",
                                            ]);
                                            
                                            break;
                                    }
                                ?>
                            </div>
                        <?php } ?>
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
                    <button type="button" class="btn btn-success btn-block btn-add" data-table="<?= "groups-$model->id" ?>">
                        <i class="fa fa-plus"></i>
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
