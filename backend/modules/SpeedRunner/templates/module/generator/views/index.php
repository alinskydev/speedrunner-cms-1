<?php

use yii\helpers\ArrayHelper;

$title = ($model->module_name == $model->controller_name) ? $model->module_name : $model->module_name . ' ' . $model->controller_name;

//      ATTRIBUTES

$attrs = $model->attrs_fields ?: [];
$attrs = array_filter($attrs, function ($value) {
    return ArrayHelper::getValue($value, 'grid_view');
});

$template = in_array('view', $model->controller_actions) ? '{view} ' : null;
$template .= in_array('update', $model->controller_actions) ? '{update} ' : null;
$template .= in_array('delete', $model->controller_actions) ? '{delete}' : null;

echo '<?php';

?>


use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;

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
        'filterModel' => $modelSearch,
        'columns' => [
            [
                'class' => 'common\components\framework\grid\CheckboxColumn',
            ],
<?php
    foreach ($attrs as $key => $a) {
        switch ($a['type']) {
            case 'checkbox':
                echo "            '$key:boolean',\n";
                break;
            case 'select':
                echo "            [
                'attribute' => '$key',
                'format' => 'raw',
                'filter' => [],
                'value' => function (\$model) {
                    return \$model->$key;
                },
            ],\n";
                
                break;
            case 'ElFinder':
                echo "            [
                'format' => 'raw',
                'filter' => false,
                'header' => '&nbsp;',
                'value' => function(\$model) {
                    return Html::img(Yii::\$app->sr->image->thumb(\$model->$key, [40, 40]));
                },
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
                    case 'url':
                        echo "            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function (\$model) {
                    return Html::a(\$model->url, Yii::\$app->urlManagerFrontend->createUrl(['', 'url' => \$model->url]), ['target' => '_blank']);
                },
            ],\n";
                        
                        break;
                    default:
                        echo "            '$key',\n";
                        break;
                }
                
                break;
        }
    }
?>
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '<?= $template ?>',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
