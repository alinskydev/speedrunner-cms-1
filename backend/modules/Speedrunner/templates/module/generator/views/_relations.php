<?php

use yii\helpers\ArrayHelper;

//      Relations DB schema

foreach ($model->view_relations as $r) {
    $attrs = ['id', 'item_id', 'sort'];
    $dbSchema = Yii::$app->db->schema;
    
    $columns = $dbSchema->getTableSchema($relation['model'])->columns;
    
    foreach ($attrs as $a) {
        unset($columns[$a]);
    }
}

$var_name_relation = str_replace('_tmp', null, $relation['var_name']);

echo '<?php';

?>


use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\<?= $model->module_name ?>\models\<?= $relation['model'] ?>;

$relations = ArrayHelper::merge($model-><?= $var_name_relation ?>, [new <?= $relation['model'] ?>]);

?>

<table class="table table-relations">
    <thead>
        <tr>
            <th style="width: 50px;"></th>
<?php foreach ($columns as $key => $c) { ?>
            <th><?= '<?= ' ?>$relations[0]->getAttributeLabel('<?= $key ?>') ?></th>
<?php } ?>
            <th style="width: 50px;"></th>
        </tr>
    </thead>
    
    <tbody data-sr-trigger="sortable">
        <?= "<?php foreach (\$relations as \$value) { ?>\n" ?>
            <?= "<?php \$value_id = \$value->isNewRecord ? '__key__' : \$value->id ?>\n" ?>
            
            <tr class="<?= "<?= \$value->isNewRecord ? 'table-new-relation' : null ?>" ?>" data-table="<?= $var_name_relation ?>">
                <td>
                    <div class="btn btn-primary table-sorter">
                        <i class="fas fa-arrows-alt"></i>
                    </div>
                </td>
                
<?php foreach ($columns as $key => $c) { ?>
                <td>
                    <?= '<?= ' ?>$form->field($value, '<?= $key ?>', ['template' => '{input}'])->textArea([
                        'name' => "<?= $model->model_name ?>[<?= $relation['var_name'] ?>][$value_id][<?= $key ?>]",
                        'rows' => 5,
                    ]) ?>
                </td>
                
<?php } ?>
                <td>
                    <button type="button" class="btn btn-danger btn-remove">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        <?= '<?php ' ?>} ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td colspan="<?= count($columns) + 2 ?>">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="<?= $var_name_relation ?>">
                    <i class="fas fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
