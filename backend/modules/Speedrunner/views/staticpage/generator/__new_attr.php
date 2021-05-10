<?php

use yii\helpers\Html;

$unique_id = uniqid();

$attr_input_types = Yii::$app->params['input_types'];
unset($attr_input_types['select'], $attr_input_types['select2_ajax'], $attr_input_types['files'], $attr_input_types['groups']);

?>

<div class="page-attrs">
    <div class="mb-2" style="display: flex;">
        <?= Html::textInput(
            "GeneratorForm[blocks][$block][attrs][$unique_id][name]",
            null,
            ['class' => 'form-control', 'placeholder' => 'Name', 'required' => true]
        ); ?>
        
        <button type="button" class="btn btn-danger btn-attr-remove">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="mb-2">
        <?= Html::textInput(
            "GeneratorForm[blocks][$block][attrs][$unique_id][label]",
            null,
            ['class' => 'form-control', 'placeholder' => 'Label', 'required' => true]
        ); ?>
    </div>
    
    <div class="mb-2">
        <?= Html::dropdownList(
            "GeneratorForm[blocks][$block][attrs][$unique_id][input_type]",
            null,
            $attr_input_types,
            ['class' => 'form-control']
        ); ?>
    </div>
    <hr>
</div>
