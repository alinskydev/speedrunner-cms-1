<?php

use yii\helpers\Html;

$types = [
    'controller' => 'Controller',
    'model' => 'Model',
    'view_index' => 'View (index)',
    'view_update' => 'View (update)',
];

$values = [
    'yii\helpers\ArrayHelper' => 'ArrayHelper',
    'vova07\imperavi\Widget' => 'Text editor',
    'zxbodya\yii2\elfinder\ElFinderInput' => 'File manager',
    'backend\modules\MODULE\models\MODEL' => 'backend\modules\MODULE\models\MODEL',
];

?>

<h4 class="text-center text-bold"><?= Yii::t('speedrunner', 'Use') ?></h4><br>

<table class="table table-relations">
    <thead>
        <tr>
            <th style="width: 2%;"></th>
            <th style="width: 15%;"><?= Yii::t('speedrunner', 'Type') ?></th>
            <th style="width: 80%;"><?= Yii::t('speedrunner', 'Value') ?></th>
            <th style="width: 3%;"></th>
        </tr>
    </thead>
    <tbody>
        <tr class="table-new-relation" data-table="use">
            <td class="table-sorter">
                <i class="fas fa-arrows-alt"></i>
            </td>
            <td>
                <?= Html::dropdownList('GeneratorForm[use][__key__][type]', null, $types, ['class' => 'form-control']); ?>
            </td>
            <td>
                <?= Html::dropdownList('GeneratorForm[use][__key__][value]', null, $values, [
                    'class' => 'form-control selectpicker-type-2',
                ]) ?>
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
            <td colspan="4">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="use">
                    <i class="fa fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
