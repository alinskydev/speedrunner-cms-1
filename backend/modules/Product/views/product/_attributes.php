<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$options = ArrayHelper::getColumn($model->options, 'id');

foreach ($attributes as $key => $a) {
    echo Html::tag('h5', $a['name']);
    
    switch ($a['type']) {
        case 'select':
            echo Html::dropDownList(
                'Product[options_tmp][' . $a['id'] . '][]',
                $options,
                ArrayHelper::map($a['options'], 'id', 'name'),
                [
                    'class' => 'form-control',
                ]
            );
            
            break;
        case 'checkbox':
            echo Html::checkboxList(
                'Product[options_tmp][' . $a['id'] . '][]',
                $options,
                ArrayHelper::map($a['options'], 'id', 'name'),
                [
                    'separator' => Html::tag('div', null, ['class' => 'mb-2']),
                    'item' => function ($index, $label, $name, $checked, $value) use ($a) {
                        $result = Html::checkbox('Product[options_tmp][' . $a['id'] . '][]', $checked, [
                            'id' => "productoption-$value",
                            'class' => 'custom-control-input',
                            'value' => $value
                        ]);
                        
                        $result .= Html::label($label, "productoption-$value", ['class' => 'custom-control-label']);
                        return Html::tag('div', $result, ['class' => 'custom-control custom-switch']);
                    }
                ]
            );
            
            break;
    }
    
    echo ($key + 1 < count($attributes)) ? '<hr>' : null;
}

