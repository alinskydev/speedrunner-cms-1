<?php

use yii\helpers\ArrayHelper;
use yii\db\mysql\ColumnSchema;

//        DB schema

$dbSchema = Yii::$app->db->schema;
$columns = $dbSchema->getTableSchema($model->table_name)->columns;
$attrs_fields = ArrayHelper::index($model->attrs_fields, null, 'type');

//        Rules

foreach ($model->view_relations as $r) {
    $columns[$r['var_name']] = new ColumnSchema();
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
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;


class <?= $model->table_name ?> extends ActiveRecord
{
<?php if ($model->view_relations) { ?>
<?php foreach ($model->view_relations as $r) { ?>
    public $<?= $r['var_name'] ?>;
<?php } ?>
    
<?php } ?>
    public static function tableName()
    {
        return '<?= $model->table_name ?>';
    }
    
<?php if (isset($attrs['slug']) || $model->attrs_translation || isset($attrs_fields['files']) || $model->view_relations) { ?>
    public function behaviors()
    {
        return [
<?php if (isset($attrs['slug'])) { ?>
            'sluggable' => [
                'class' => \yii\behaviors\SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => true,
            ],
<?php } ?>
<?php if ($model->attrs_translation) { ?>
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
                'attributes' => ['<?= implode("', '", array_keys($model->attrs_translation)) ?>'],
            ],
<?php } ?>
<?php if (isset($attrs_fields['files'])) { ?>
<?php $file_attributes = ArrayHelper::getColumn($attrs_fields['files'], 'name') ?>
            'files' => [
                'class' => \speedrunner\behaviors\FileBehavior::className(),
                'attributes' => ['<?= implode("', '", $file_attributes) ?>'],
                'multiple' => true,
            ],
<?php } ?>
<?php if ($model->has_seo_meta) { ?>
            'seo_meta' => [
                'class' => \speedrunner\behaviors\SeoMetaBehavior::className(),
            ],
<?php } ?>
<?php if ($model->view_relations) { ?>
            'relations_one_many' => [
                'class' => \speedrunner\behaviors\RelationBehavior::className(),
                'type' => 'oneMany',
                'attributes' => [
<?php foreach ($model->view_relations as $r) { ?>
                    '<?= $r['var_name'] ?>' => [
                        'model' => new <?= $r['model'] ?>(),
                        'relation' => '<?= str_replace('_tmp', null, $r['var_name']) ?>',
                        'attributes' => [
                            'main' => '',
                            'relational' => [],
                        ],
                    ],
<?php } ?>
                ],
            ],
<?php } ?>
        ];
    }
    
<?php } ?>
    public function rules()
    {
        return [<?= empty($rules) ? null : ("\n            " . implode(",\n            ", $rules) . ",\n        ") ?>];
    }
    
    public function attributeLabels()
    {
        return [
<?php foreach ($attrs as $key => $a) { ?>
            '<?= $key ?>' => Yii::t('app', '<?= str_replace('_', ' ', ucfirst($key)) ?>'),
<?php } ?>
        ];
    }
<?php foreach ($model->model_relations as $r) { ?>
    
    public function get<?= $r['name'] ?>()
    {
        return $this-><?= $r['type'] ?>(<?= $r['model'] ?>::className(), [<?= "'" . $r['cond_from'] . "' => '" . $r['cond_to'] . "'" ?>]);
    }
<?php } ?>
}
