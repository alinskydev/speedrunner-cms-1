<?php

use yii\helpers\ArrayHelper;
use yii\db\mysql\ColumnSchema;

//      DB SCHEMA

$dbSchema = Yii::$app->db->schema;
$columns = $dbSchema->getTableSchema($model->table_name)->columns;

//      RULES

foreach ($model->view_relations as $r) {
    $columns[$r['var_name']] = new ColumnSchema;
    $columns[$r['var_name']]->name = $r['var_name'];
    $columns[$r['var_name']]->allowNull = true;
    $columns[$r['var_name']]->type = 'json';
    $columns[$r['var_name']]->phpType = 'json';
    $columns[$r['var_name']]->dbType = 'json';
}

$rules = $model->generateRules($columns);

$attrs = $model->attrs_fields ?: [];

echo '<?php';

?>


namespace backend\modules\<?= $model->module_name ?>\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
<?php if(isset($attrs['url'])) { ?>
use yii\behaviors\SluggableBehavior;
<?php } ?>


class <?= $model->table_name ?> extends ActiveRecord
{
<?php if ($model->attrs_translation) { ?>
    public $translation_attrs = [
<?php foreach ($model->attrs_translation as $key => $a) { ?>
        '<?= $key ?>',
<?php } ?>
    ];

<?php } ?>
<?php if ($model->view_relations) { ?>
<?php foreach ($model->view_relations as $r) { ?>
    public $<?= $r['var_name'] ?>;
<?php } ?>

<?php } ?>
<?php if ($model->has_seo_meta) { ?>
    public $seo_meta = [];
    
<?php } ?>
    public static function tableName()
    {
        return '<?= $model->table_name ?>';
    }

<?php if(isset($attrs['url'])) { ?>
    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'url',
                'immutable' => true,
            ],
        ];
    }

<?php } ?>
    public function rules()
    {
        return [<?= empty($rules) ? '' : ("\n            " . implode(",\n            ", $rules) . ",\n        ") ?>];
    }

    public function attributeLabels()
    {
        return [
<?php foreach ($attrs as $key => $a) { ?>
            '<?= $key ?>' => Yii::t('app', '<?= str_replace(['_'], [' '], ucfirst($key)) ?>'),
<?php } ?>
        ];
    }
<?php foreach ($model->model_relations as $r) { ?>

    public function get<?= $r['name'] ?>()
    {
        return $this-><?= $r['type'] ?>(<?= $r['model'] ?>::className(), [<?= "'" . $r['cond_from'] . "' => '" . $r['cond_to'] . "'" ?>]);
    }
<?php } ?>
<?php if ($model->view_relations) { ?>

    public function afterSave($insert, $changedAttributes)
    {
<?php foreach ($model->view_relations as $r) { ?>
<?php
    $var_name = $r['var_name'];
    $var_name_rel = str_replace('_tmp', '', $var_name);
    $var_name_mdl = str_replace('_tmp', '_mdl', $var_name);
?>
        //        <?= strtoupper($var_name_rel) . "\n" ?>

        $<?= $var_name_rel ?> = ArrayHelper::index($this-><?= $var_name_rel ?>, 'id');

        if ($this-><?= $var_name ?>) {
            $counter = 0;

            foreach ($this-><?= $var_name ?> as $key => $value) {
                $<?= $var_name_mdl ?> = <?= $r['model'] ?>::findOne($key) ?: new <?= $r['model'] ?>;
                $<?= $var_name_mdl ?>->item_id = $this->id;
                //        ATTRS
                $<?= $var_name_mdl ?>->sort = $counter;
                $<?= $var_name_mdl ?>->save();

                ArrayHelper::remove($<?= $var_name_rel ?>, $key);

                $counter++;
            }
        }

        foreach ($<?= $var_name_rel ?> as $value) { $value->delete(); };

<?php } ?>
        return parent::afterSave($insert, $changedAttributes);
    }
<?php } ?>
}
