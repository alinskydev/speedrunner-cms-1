<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\Log\services\LogActionService;

?>

<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?= Yii::t('app', 'Log actions #{id}', ['id' => $model->id]) ?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="table-responsive">
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
                                <?= (new LogActionService($model))->attrsColumn('old', 'full') ?>
                            </td>
                            <td>
                                <?= (new LogActionService($model))->attrsColumn('new', 'full') ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>