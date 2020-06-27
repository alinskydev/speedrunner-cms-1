<?php

use yii\helpers\ArrayHelper;

//      RELATIONS DB SCHEMA

foreach ($model->view_relations as $r) {
    $attrs = ['id', 'item_id', 'sort', 'lang'];
    $dbSchema = Yii::$app->db->schema;
    
    $columns = $dbSchema->getTableSchema($relation['model'])->columns;
    
    foreach ($attrs as $a) {
        unset($columns[$a]);
    }
}

$var_name_relation = str_replace('_tmp', '', $relation['var_name']);

echo '<?php';

?>


use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\<?= $model->module_name ?>\models\<?= $relation['model'] ?>;

$<?= $var_name_relation ?> = ArrayHelper::merge($model-><?= $var_name_relation ?>, [new <?= $relation['model'] ?>]);

?>

<table class="table table-bordered table-relations">
    <thead>
        <tr>
            <th></th>
<?php foreach ($columns as $key => $c) { ?>
            <th><?= '<?= ' ?>$<?= $var_name_relation ?>[0]->getAttributeLabel('<?= $key ?>') ?></th>
<?php } ?>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        <?= "<?php foreach ($$var_name_relation as \$value) { ?>\n" ?>
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
                        'name' => "<?= $model['table_name'] ?>[<?= $relation['var_name'] ?>][$value_id][<?= $key ?>]",
                        'rows' => 5,
                    ]) ?>
                    <button class="btn btn-info btn-xs btn-view" type="button"><i class="fa fa-eye"></i></button>
                </td>
                
<?php } ?>
                <td>
                    <button type="button" class="btn btn-danger btn-remove">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        <?= '<?php ' ?>} ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td colspan="<?= count($columns) + 2 ?>">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="<?= $var_name_relation ?>">
                    <i class="fa fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
