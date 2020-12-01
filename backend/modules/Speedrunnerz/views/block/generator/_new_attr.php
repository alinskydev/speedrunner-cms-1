<?php

use yii\helpers\Html;

$rnd_number = round(microtime(true) * 1000);

$attr_types = Yii::$app->params['input_types'];
unset($attr_types['images'], $attr_types['groups']);

?>

<div class="block-attrs">
    <div class="mb-2" style="display: flex;">
        <?= Html::textInput(
            "GeneratorForm[blocks][$block][attrs][$rnd_number][name]",
            null,
            ['class' => 'form-control', 'placeholder' => 'Name', 'required' => true]
        ); ?>
        
        <button type="button" class="btn btn-danger btn-attr-remove">
            <i class="fa fa-times"></i>
        </button>
    </div>
    
    <div class="mb-2">
        <?= Html::textInput(
            "GeneratorForm[blocks][$block][attrs][$rnd_number][label]",
            null,
            ['class' => 'form-control', 'placeholder' => 'Label', 'required' => true]
        ); ?>
    </div>
    
    <div class="mb-2">
        <?= Html::dropdownList(
            "GeneratorForm[blocks][$block][attrs][$rnd_number][type]",
            null,
            $attr_types,
            ['class' => 'form-control', 'placeholder' => 'Type']
        ); ?>
    </div>
    <hr>
</div>
