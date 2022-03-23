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
use backend\widgets\crud\RelationsWidget;
use speedrunner\widgets\TranslationActiveField;

use backend\modules\<?= $model->module_name ?>\models\<?= $relation['model'] ?>;

echo RelationsWidget::widget([
    'form' => $form,
    'relations' => ArrayHelper::merge($model-><?= $var_name_relation ?>, [new <?= $relation['model'] ?>()]),
    'name_prefix' => '<?= $relation['model'] ?>[<?= $relation['var_name'] ?>]',
    'attributes' => [
<?php foreach ($columns as $key => $c) { ?>
        [
            'name' => '<?= $key ?>',
            'type' => 'text_input',
            'container_options' => [
                'class' => TranslationActiveField::className(),
            ],
        ],
<?php } ?>
    ],
]);
