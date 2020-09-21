<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use zxbodya\yii2\elfinder\ElFinderInput;

use backend\modules\Banner\models\BannerGroup;

$groups = ArrayHelper::merge($model->groups, [new BannerGroup]);

?>

<table class="table table-bordered table-relations">
    <thead>
        <tr>
            <th></th>
            <th><?= $groups[0]->getAttributeLabel('text_1') ?></th>
            <th><?= $groups[0]->getAttributeLabel('text_2') ?></th>
            <th><?= $groups[0]->getAttributeLabel('text_3') ?></th>
            <th><?= $groups[0]->getAttributeLabel('link') ?></th>
            <th><?= $groups[0]->getAttributeLabel('image') ?></th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($groups as $value) { ?>
            <?php $value_id = $value->isNewRecord ? '__key__' : $value->id ?>
            
            <tr class="<?= $value->isNewRecord ? 'table-new-relation' : null ?>" data-table="groups">
                <td>
                    <div class="btn btn-primary table-sorter">
                        <i class="fas fa-arrows-alt"></i>
                    </div>
                </td>
                
                <td>
                    <?= $form->field($value, 'text_1', ['template' => '{input}'])->textArea([
                        'name' => "Banner[groups_tmp][$value_id][text_1]",
                        'class' => 'form-control',
                        'rows' => 5,
                    ]) ?>
                    <button class="btn btn-info btn-xs btn-view" type="button"><i class="fa fa-eye"></i></button>
                </td>
                
                <td>
                    <?= $form->field($value, 'text_2', ['template' => '{input}'])->textArea([
                        'name' => "Banner[groups_tmp][$value_id][text_2]",
                        'class' => 'form-control',
                        'rows' => 5,
                    ]) ?>
                    <button class="btn btn-info btn-xs btn-view" type="button"><i class="fa fa-eye"></i></button>
                </td>
                
                <td>
                    <?= $form->field($value, 'text_3', ['template' => '{input}'])->textArea([
                        'name' => "Banner[groups_tmp][$value_id][text_3]",
                        'class' => 'form-control',
                        'rows' => 5,
                    ]) ?>
                    <button class="btn btn-info btn-xs btn-view" type="button"><i class="fa fa-eye"></i></button>
                </td>
                
                <td>
                    <?= $form->field($value, 'link', ['template' => '{input}'])->textArea([
                        'name' => "Banner[groups_tmp][$value_id][link]",
                        'class' => 'form-control',
                        'rows' => 5,
                    ]) ?>
                    <button class="btn btn-info btn-xs btn-view" type="button"><i class="fa fa-eye"></i></button>
                </td>
                
                <td>
                    <?= $form->field($value, 'image', [
                        'template' => '{input}'
                    ])->widget(ElFinderInput::className(), [
                        'connectorRoute' => '/connection/elfinder-file-upload',
                        'name' => "Banner[groups_tmp][$value_id][image]",
                        'id' => "elfinder-$value_id",
                    ]) ?>
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
            <td colspan="7">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="groups">
                    <i class="fa fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
