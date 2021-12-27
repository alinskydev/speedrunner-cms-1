<?php

$index_title = ($model->module_name == $model->controller_name) ? $model->module_name : "$model->module_name " . mb_strtolower($model->controller_name);

//      Attributes

$attrs = $model->attrs_fields ?: [];
$controller_url = mb_strtolower($model->module_name) . '/' . mb_strtolower($model->controller_name);

echo '<?php';

?>


use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\widgets\crud\UpdateWidget;
use speedrunner\widgets\TranslationActiveField;

$this->title = Yii::$app->helpers->html->pageTitle($model);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '<?= $index_title ?>s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

echo UpdateWidget::widget([
    'model' => $model,
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
<?php
    foreach ($attrs as $key => $a) {
        switch ($a['type']) {
            case 'text_input':
            case 'text_area':
            case 'checkbox':
            case 'file_manager':
            case 'text_editor':
                echo "                '$key' => '{$a['type']}',\n";
                break;
            
            case 'select':
                echo "                [
                    'name' => '$key',
                    'type' => '{$a['type']}',
                    'data' => ArrayHelper::getColumn(\$model->{selectionList}(), 'label'),
                ],\n";
                break;
            
            case 'select2_ajax':
                echo "                [
                    'name' => '$key',
                    'type' => '{$a['type']}',
                    'data' => [\$model->$key => ArrayHelper::getValue(\$model->{relation}, '{attribute}')],
                    'widget_options' => [
                        'ajax_url' => Yii::\$app->urlManager->createUrl(['items-list/{relation_model}']),
                    ]
                ],\n";
                break;
            
            case 'files':
                echo "                [
                    'name' => '$key',
                    'type' => '{$a['type']}',
                    'multiple' => true,
                    'widget_options' => [
                        'delete_url' => Yii::\$app->urlManager->createUrl([
                            '$controller_url/file-delete', 'id' => \$model->id, 'attr' => '$key'
                        ]),
                        'sort_url' => Yii::\$app->urlManager->createUrl([
                            '$controller_url/file-sort', 'id' => \$model->id, 'attr' => '$key'
                        ]),
                    ],
                ],\n";
                break;
            
        }
    }
?>
            ],
        ],
<?php foreach ($model->view_relations as $r) { ?>
<?php $var_name_rel = str_replace('_tmp', null, $r['var_name']); ?>
        '<?= $var_name_rel ?>' => [
            'label' => Yii::t('app', '<?= ucfirst($var_name_rel) ?>'),
            'attributes' => [
                [
                    'name' => false,
                    'type' => 'render',
                    'view' => '_<?= $var_name_rel ?>',
                ],
            ],
        ],
<?php } ?>
    ],
]);
