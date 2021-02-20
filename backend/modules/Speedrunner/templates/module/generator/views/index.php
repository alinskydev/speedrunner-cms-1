<?php

use yii\helpers\ArrayHelper;

$title = ($model->module_name == $model->controller_name) ? $model->module_name : "$model->module_name " . strtolower($model->controller_name);

//      Attributes

$attrs = $model->attrs_fields ?: [];
$attrs = array_filter($attrs, fn ($value) => ArrayHelper::getValue($value, 'grid_view'));

$buttons_template[] = in_array('view', $model->controller_actions) ? '{view} ' : null;
$buttons_template[] = in_array('update', $model->controller_actions) ? '{update} ' : null;
$buttons_template[] = in_array('delete', $model->controller_actions) ? '{delete}' : null;

echo '<?php';

?>


use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use speedrunner\widgets\grid\GridView;

$this->title = Yii::t('app', '<?= $title ?>s');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= "<?= \$this->title ?>\n" ?>
<?php
    if (in_array('create', $model->controller_actions)) {
        echo "    <?= Html::a(
        Html::tag('i', null, ['class' => 'fas fa-plus-square']) . Yii::t('app', 'Create'),
        ['create'],
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>\n";
    }
?>
</h2>

<div class="main-shadow p-3">
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'speedrunner\widgets\grid\CheckboxColumn',
            ],
<?php
    foreach ($attrs as $key => $a) {
        switch ($a['type']) {
            case 'checkbox':
                echo "            '$key:boolean',\n";
                break;
            
            case 'select':
            case 'select2_ajax':
                echo "            [
                'attribute' => '$key',
                'format' => 'raw',
                'filter' => [],
                'value' => fn (\$model) => \$model->$key,
            ],\n";
                break;
            
            case 'elfinder':
                echo "            [
                'header' => false,
                'format' => 'raw',
                'filter' => false,
                'value' => fn (\$model) => Html::img(Yii::\$app->services->image->thumb(\$model->$key, [40, 40], 'resize')),
                'headerOptions' => [
                    'style' => 'width: 65px;'
                ],
            ],\n";
                break;
            
            default:
                switch ($key) {
                    case 'id':
                        echo "            [
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ],
            ],\n";
                        break;
                    
                    case 'slug':
                        echo "            [
                'attribute' => 'slug',
                'format' => 'raw',
                'value' => fn (\$model) => Html::a(
                    \$model->slug,
                    Yii::\$app->urlManagerFrontend->createUrl(['{route}', 'slug' => \$model->slug]),
                    ['target' => '_blank']
                ),
            ],\n";
                        break;
                    
                    default:
                        echo "            '$key',\n";
                }
        }
    }
?>
            [
                'class' => 'speedrunner\widgets\grid\ActionColumn',
                'template' => '<?= implode(null, $buttons_template) ?>',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
