<?php

use yii\helpers\Html;

$rnd_number = round(microtime(true) * 1000);

?>

<tr>
    <td>
        <div class="btn btn-primary table-sorter">
            <i class="fas fa-arrows-alt"></i>
        </div>
    </td>
    <td>
        <?= Html::input('text', "GeneratorForm[blocks][$rnd_number][name]", null, ['class' => 'form-control', 'required' => true]); ?>
    </td>
    <td>
        <?= Html::input('text', "GeneratorForm[blocks][$rnd_number][label]", null, ['class' => 'form-control', 'required' => true]); ?>
    </td>
    <td>
        <div class="custom-control custom-switch">
            <?php
                echo Html::checkbox("GeneratorForm[blocks][$rnd_number][has_translation]", null, [
                    'uncheck' => 0,
                    'id' => "generatorform-$rnd_number",
                    'class' => 'custom-control-input',
                ]);

                echo Html::label(null, "generatorform-$rnd_number", ['class' => 'custom-control-label']);
            ?>
        </div>
    </td>
    <td>
        <?= Html::dropdownList("GeneratorForm[blocks][$rnd_number][type]", null, Yii::$app->params['input_types'], ['class' => 'form-control']); ?>
    </td>
    <td>
        <div class="page-attrs-wrap"></div>

        <button type="button"
                class="btn btn-success btn-block btn-attr-add"
                data-action="<?= Yii::$app->urlManager->createUrl(['speedrunner/staticpage/generator/new-attr', 'block' => $rnd_number]) ?>"
        >
            <i class="fas fa-plus"></i>
        </button>
    </td>
    <td class="text-right">
        <?= Html::hiddenInput('GeneratorForm[blocks]['.$rnd_number.'][part_name]', $part_name); ?>
        <?= Html::hiddenInput('GeneratorForm[blocks]['.$rnd_number.'][part_index]', $part_index); ?>

        <button type="button" class="btn btn-danger btn-block-remove">
            <i class="fas fa-times"></i>
        </button>
    </td>
</tr>
