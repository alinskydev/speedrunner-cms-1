<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use alexantr\elfinder\InputFile;
use speedrunner\widgets\TranslationActiveField;

use backend\modules\Banner\models\BannerGroup;

$relations = ArrayHelper::merge($model->groups, [new BannerGroup()]);

?>

<table class="table table-relations">
    <thead>
        <tr>
            <th style="width: 50px;"></th>
            <th><?= $relations[0]->getAttributeLabel('text_1') ?></th>
            <th><?= $relations[0]->getAttributeLabel('text_2') ?></th>
            <th><?= $relations[0]->getAttributeLabel('text_3') ?></th>
            <th><?= $relations[0]->getAttributeLabel('link') ?></th>
            <th><?= $relations[0]->getAttributeLabel('image') ?></th>
            <th style="width: 50px;"></th>
        </tr>
    </thead>
    
    <tbody data-sr-trigger="sortable">
        <?php foreach ($relations as $value) { ?>
            <?php $value_id = $value->isNewRecord ? '__key__' : $value->id ?>
            
            <tr class="<?= $value->isNewRecord ? 'table-new-relation' : null ?>" data-table="groups">
                <td>
                    <div class="btn btn-primary table-sorter">
                        <i class="fas fa-arrows-alt"></i>
                    </div>
                </td>
                
                <td>
                    <?= $form->field($value, 'text_1', [
                        'class' => TranslationActiveField::className(),
                        'template' => '{input}',
                    ])->textArea([
                        'name' => "Banner[groups_tmp][$value_id][text_1]",
                        'rows' => 5,
                    ]) ?>
                </td>
                
                <td>
                    <?= $form->field($value, 'text_2', [
                        'class' => TranslationActiveField::className(),
                        'template' => '{input}',
                    ])->textArea([
                        'name' => "Banner[groups_tmp][$value_id][text_2]",
                        'rows' => 5,
                    ]) ?>
                </td>
                
                <td>
                    <?= $form->field($value, 'text_3', [
                        'class' => TranslationActiveField::className(),
                        'template' => '{input}',
                    ])->textArea([
                        'name' => "Banner[groups_tmp][$value_id][text_3]",
                        'rows' => 5,
                    ]) ?>
                </td>
                
                <td>
                    <?= $form->field($value, 'link', [
                        'class' => TranslationActiveField::className(),
                        'template' => '{input}',
                    ])->textArea([
                        'name' => "Banner[groups_tmp][$value_id][link]",
                        'rows' => 5,
                    ]) ?>
                </td>
                
                <td>
                    <?= $form->field($value, 'image', [
                        'template' => '{input}',
                        'options' => [
                            'data-sr-trigger' => 'file_manager',
                        ],
                    ])->widget(InputFile::className(), [
                        'options' => [
                            'id' => "banner-groups-image-$value_id",
                            'name' => "Banner[groups_tmp][$value_id][image]",
                        ]
                    ]) ?>
                </td>
                
                <td>
                    <button type="button" class="btn btn-danger btn-remove">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td colspan="7">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="groups">
                    <i class="fas fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
