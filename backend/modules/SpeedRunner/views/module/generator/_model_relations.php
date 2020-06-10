<?php

use yii\helpers\Html;

$types = [
    'hasOne' => 'hasOne',
    'hasMany' => 'hasMany',
];

?>

<h4 class="text-center text-bold"><?= Yii::t('speedrunner', 'Model relations') ?></h4>
<br>

<table class="table table-relations">
    <thead>
        <tr>
            <th style="width: 2%;"></th>
            <th style="width: 20%;"><?= Yii::t('speedrunner', 'Name') ?></th>
            <th style="width: 15%;"><?= Yii::t('speedrunner', 'Type') ?></th>
            <th style="width: 20%;"><?= Yii::t('speedrunner', 'Model') ?></th>
            <th style="width: 20%;"><?= Yii::t('speedrunner', 'Condition (from)') ?></th>
            <th style="width: 20%;"><?= Yii::t('speedrunner', 'Condition (to)') ?></th>
            <th style="width: 3%;"></th>
        </tr>
    </thead>
    <tbody>
        <tr class="table-new-relation" data-table="model_relations">
            <td class="table-sorter">
                <i class="fas fa-arrows-alt"></i>
            </td>
            <td>
                <?= Html::input('text', 'GeneratorForm[model_relations][__key__][name]', null, ['class' => 'form-control model_relations-name']); ?>
            </td>
            <td>
                <?= Html::dropdownList('GeneratorForm[model_relations][__key__][type]', null, $types, ['class' => 'form-control']); ?>
            </td>
            <td>
                <?= Html::input('text', 'GeneratorForm[model_relations][__key__][model]', null, ['class' => 'form-control model_relations-model']); ?>
            </td>
            <td>
                <?= Html::input('text', 'GeneratorForm[model_relations][__key__][cond_from]', null, ['class' => 'form-control']); ?>
            </td>
            <td>
                <?= Html::input('text', 'GeneratorForm[model_relations][__key__][cond_to]', null, ['class' => 'form-control']); ?>
            </td>
            <td class="text-right">
                <button type="button" class="btn btn-danger btn-remove">
                    <span class="fa fa-times"></span>
                </button>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="model_relations">
                    <i class="fa fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
