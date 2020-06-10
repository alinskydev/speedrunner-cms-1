<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use zxbodya\yii2\elfinder\ElFinderInput;

use backend\modules\Banner\models\BannerImage;

$images = ArrayHelper::merge($model->images, [new BannerImage]);

?>

<table class="table table-relations">
    <thead>
        <tr>
            <th></th>
            <th><?= $images[0]->getAttributeLabel('text_1') ?></th>
            <th><?= $images[0]->getAttributeLabel('text_2') ?></th>
            <th><?= $images[0]->getAttributeLabel('text_3') ?></th>
            <th><?= $images[0]->getAttributeLabel('link') ?></th>
            <th><?= $images[0]->getAttributeLabel('image') ?></th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($images as $img) { ?>
            <?php $img_id = $img->isNewRecord ? '__key__' : $img->id ?>
            
            <tr class="<?= $img->isNewRecord ? 'table-new-relation' : null ?>" data-table="images">
                <td class="table-sorter">
                    <i class="fas fa-arrows-alt"></i>
                </td>
                <td>
                    <?= $form->field($img, 'text_1', ['template' => '{input}'])->textArea([
                        'name' => "Banner[images_tmp][$img_id][text_1]",
                        'class' => 'form-control',
                        'rows' => 7,
                    ]) ?>
                    <button class="btn btn-info btn-xs btn-view" type="button"><i class="fa fa-eye"></i></button>
                </td>
                <td>
                    <?= $form->field($img, 'text_2', ['template' => '{input}'])->textArea([
                        'name' => "Banner[images_tmp][$img_id][text_2]",
                        'class' => 'form-control',
                        'rows' => 7,
                    ]) ?>
                    <button class="btn btn-info btn-xs btn-view" type="button"><i class="fa fa-eye"></i></button>
                </td>
                <td>
                    <?= $form->field($img, 'text_3', ['template' => '{input}'])->textArea([
                        'name' => "Banner[images_tmp][$img_id][text_3]",
                        'class' => 'form-control',
                        'rows' => 7,
                    ]) ?>
                    <button class="btn btn-info btn-xs btn-view" type="button"><i class="fa fa-eye"></i></button>
                </td>
                <td>
                    <?= $form->field($img, 'link', ['template' => '{input}'])->textArea([
                        'name' => "Banner[images_tmp][$img_id][link]",
                        'class' => 'form-control',
                        'rows' => 7,
                    ]) ?>
                    <button class="btn btn-info btn-xs btn-view" type="button"><i class="fa fa-eye"></i></button>
                </td>
                <td>
                    <?= $form->field($img, 'image', [
                        'template' => '{input}'
                    ])->widget(ElFinderInput::className(), [
                        'connectorRoute' => '/connection/elfinder-file-upload',
                        'name' => "Banner[images_tmp][$img_id][image]",
                        'id' => "elfinder-$img_id",
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
                <button type="button" class="btn btn-success btn-block btn-add" data-table="images">
                    <i class="fa fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
