<?php

use yii\helpers\Html;

$unique_id = uniqid();

$attr_input_types = Yii::$app->params['input_types'];
unset($attr_input_types['select'], $attr_input_types['select2_ajax']);

?>

<tr>
    <td>
        <div class="btn btn-primary table-sorter">
            <i class="fas fa-arrows-alt"></i>
        </div>
    </td>
    <td>
        <?= Html::input('text', "GeneratorForm[blocks][$unique_id][name]", null, ['class' => 'form-control', 'required' => true]); ?>
    </td>
    <td>
        <?= Html::input('text', "GeneratorForm[blocks][$unique_id][label]", null, ['class' => 'form-control', 'required' => true]); ?>
    </td>
    <td>
        <div class="custom-control custom-switch">
            <?php
                echo Html::checkbox("GeneratorForm[blocks][$unique_id][has_translation]", null, [
                    'uncheck' => 0,
                    'id' => "generatorform-$unique_id",
                    'class' => 'custom-control-input',
                ]);

                echo Html::label(null, "generatorform-$unique_id", ['class' => 'custom-control-label']);
            ?>
        </div>
    </td>
    <td>
        <?= Html::dropdownList("GeneratorForm[blocks][$unique_id][input_type]", null, $attr_input_types, ['class' => 'form-control']); ?>
    </td>
    <td>
        <div class="page-attrs-wrap"></div>

        <button type="button"
                class="btn btn-success btn-block btn-attr-add"
                data-action="<?= Yii::$app->urlManager->createUrl(['speedrunner/staticpage/generator/new-attr', 'block' => $unique_id]) ?>"
        >
            <i class="fas fa-plus"></i>
        </button>
    </td>
    <td class="text-right">
        <?= Html::hiddenInput("GeneratorForm[blocks][$unique_id][part_name]", $part_name); ?>
        <?= Html::hiddenInput("GeneratorForm[blocks][$unique_id][part_index]", $part_index); ?>

        <button type="button" class="btn btn-danger btn-block-remove">
            <i class="fas fa-times"></i>
        </button>
    </td>
</tr>
