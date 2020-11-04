<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>

<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?= Yii::t('app', 'Log actions #{id}', ['id' => $model->id]) ?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?= $model->getAttributeLabel('attrs_old') ?></th>
                        <th><?= $model->getAttributeLabel('attrs_new') ?></th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td>
                            <?= $model->attrsColumn('old', 'full') ?>
                        </td>
                        <td>
                            <?= $model->attrsColumn('new', 'full') ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>