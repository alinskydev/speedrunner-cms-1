<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

foreach ($specifications as $key => $s) {
    echo Html::tag('h5', $s->name);
    
    echo Html::checkboxList(
        "Product[options_tmp][$s->id][]",
        $options,
        ArrayHelper::map($s->options, 'id', 'name'),
        [
            'separator' => Html::tag('div', null, ['class' => 'mb-2']),
            'item' => function ($index, $label, $name, $checked, $value) {
                $result = Html::checkbox('Product[options_tmp][]', $checked, [
                    'id' => "productoption-$value",
                    'class' => 'custom-control-input',
                    'value' => $value
                ]);
                
                $result .= Html::label($label, "productoption-$value", ['class' => 'custom-control-label']);
                return Html::tag('div', $result, ['class' => 'custom-control custom-switch']);
            }
        ]
    );
    
    echo ($key + 1 < count($specifications)) ? '<hr>' : null;
}
