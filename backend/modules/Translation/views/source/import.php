<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php $form = ActiveForm::begin([
            'options' => [
                'id' => 'translations-import-form',
                'data-sr-trigger' => 'ajax-form',
                'data-sr-wrapper' => '#main-modal',
            ],
        ]); ?>
        
        <div class="modal-header">
            <h4 class="modal-title">
                <?= Yii::t('app', 'Translations import') ?>
            </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
            <?= $form->field($model, 'category')->dropDownList($model->available_categories, ['prompt' => '']); ?>
            <?= $form->field($model, 'file')->fileInput(['class' => 'form-control h-auto']); ?>
        </div>
        
        <div class="modal-footer">
            <?= Html::submitButton(
                Yii::t('app', 'Import'),
                ['class' => 'btn btn-primary btn-block']
            ) ?>
        </div>
        
        <?php ActiveForm::end(); ?>
    </div>
</div>
