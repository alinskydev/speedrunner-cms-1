<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$attr_types = Yii::$app->params['input_types'];
unset($attr_types['groups']);

?>

<h4 class="mb-3">
    Attributes
</h4>

<table class="table table-relations">
    <thead>
        <tr>
            <th style="width: 2%;"></th>
            <th style="width: 20%;">Attribute</th>
            <th style="width: 3%;">GridView</th>
            <th style="width: 3%;">I18N</th>
            <th style="width: 65%;">Type</th>
        </tr>
    </thead>
    
    <tbody data-toggle="sortable">
        <?php foreach ($columns as $c) { ?>
            <tr>
                <td>
                    <div class="btn btn-primary table-sorter">
                        <i class="fas fa-arrows-alt"></i>
                    </div>
                </td>
                
                <td>
                    <?= $c->name ?>
                </td>
                
                <td>
                    <div class="custom-control custom-switch">
                        <?php
                            echo Html::checkbox("GeneratorForm[attrs_fields][$c->name][grid_view]", null, [
                                'uncheck' => 0,
                                'id' => "generatorform-attr-grid_view-$c->name",
                                'class' => 'custom-control-input',
                            ]);
                            
                            echo Html::label(null, "generatorform-attr-grid_view-$c->name", ['class' => 'custom-control-label']);
                        ?>
                    </div>
                </td>
                
                <td>
                    <div class="custom-control custom-switch">
                        <?php
                            echo Html::checkbox("GeneratorForm[attrs_fields][$c->name][has_translation]", null, [
                                'uncheck' => 0,
                                'id' => "generatorform-attr-has_translation-$c->name",
                                'class' => 'custom-control-input',
                            ]);
                            
                            echo Html::label(null, "generatorform-attr-has_translation-$c->name", ['class' => 'custom-control-label']);
                        ?>
                    </div>
                </td>
                
                <td>
                    <?php
                        echo Html::dropdownList("GeneratorForm[attrs_fields][$c->name][type]", null, $attr_types, [
                            'class' => 'form-control',
                            'prompt' => ' '
                        ]);
                        
                        echo Html::hiddenInput("GeneratorForm[attrs_fields][$c->name][name]", $c->name);
                    ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<hr>
