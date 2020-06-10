<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;

$attrs = json_decode($model->attrs, JSON_UNESCAPED_UNICODE);
$attrs = ArrayHelper::index($attrs, 'name');

foreach ($attrs as $a) {
    $name = $a['name'];
    $new_group['__key__'][$name] = null;
}

$groups = ArrayHelper::merge($model->value, $new_group);

?>

<div class="form-group">
    <?= Html::label($model->label) ?>
    <?= Html::hiddenInput("StaticPageBlock[$model->id][value]", null); ?>
    
    <table class="table table-relations">
        <tbody>
            <?php foreach ($groups as $key => $group) { ?>
                <tr class="<?= $key == '__key__' ? 'table-new-relation' : null ?>" data-table="<?= 'groups-' . $model->id ?>">
                    <td class="table-sorter">
                        <i class="fas fa-arrows-alt"></i>
                    </td>
                    
                    <td style="width: 100%;">
                        <?php foreach ($group as $g_key => $g_value) { ?>
                            <div class="form-group">
                                <label>
                                    <?= Yii::t('app', $attrs[$g_key]['label']) ?>
                                </label>
                                
                                <?php
                                    switch ($attrs[$g_key]['type']) {
                                        case 'textInput':
                                            echo Html::textInput(
                                                "StaticPageBlock[$model->id][value][$key][$g_key]",
                                                $g_value,
                                                ['class' => 'form-control']
                                            );
                                            
                                            break;
                                        case 'textArea':
                                            echo Html::textArea(
                                                "StaticPageBlock[$model->id][value][$key][$g_key]",
                                                $g_value,
                                                ['class' => 'form-control', 'rows' => 5]
                                            );
                                            
                                            break;
                                        case 'checkbox':
                                            $checkbox = Html::checkbox("StaticPageBlock[$model->id][value][$key][$g_key]", $g_value, [
                                                'uncheck' => 0,
                                                'id' => "staticpageblock-$key-$g_key",
                                                'class' => 'custom-control-input',
                                            ]);
                                            
                                            $checkbox .= Html::label(null, "staticpageblock-$key-$g_key", ['class' => 'custom-control-label']);
                                            echo Html::tag('div', $checkbox, ['class' => 'custom-control custom-switch float-left']);
                                            
                                            break;
                                        case 'CKEditor':
                                            echo Widget::widget([
                                                'name' => "StaticPageBlock[$model->id][value][$key][$g_key]",
                                                'value' => $g_value,
                                                'id' => "redactor-$key",
                                                'settings' => [
                                                    'imageUpload' => Yii::$app->urlManager->createUrl('connection/editor-image-upload'),
                                                    'imageManagerJson' => Yii::$app->urlManager->createUrl('connection/editor-images'),
                                                ],
                                            ]);
                                            
                                            break;
                                        case 'ElFinder':
                                            echo ElFinderInput::widget([
                                                'connectorRoute' => '/connection/elfinder-file-upload',
                                                'name' => "StaticPageBlock[$model->id][value][$key][$g_key]",
                                                'id' => "elfinder-$key",
                                                'value' => $g_value,
                                            ]);
                                            
                                            break;
                                    }
                                ?>
                            </div>
                        <?php } ?>
                    </td>
                    
                    <td>
                        <button type="button" class="btn btn-danger btn-remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="<?= count((array)$attrs) + 2 ?>">
                    <button type="button" class="btn btn-success btn-block btn-add" data-table="<?= 'groups-' . $model->id ?>">
                        <i class="fa fa-plus"></i>
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
