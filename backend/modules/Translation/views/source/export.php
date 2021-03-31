<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\JsExpression;

?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php $form = ActiveForm::begin([
            'options' => ['id' => 'translations-export-form'],
        ]); ?>
        
        <div class="modal-header">
            <h4 class="modal-title">
                <?= Yii::t('app', 'Translations export') ?>
            </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
            <?= $form->field($model, 'category')->dropDownList($model->available_categories, ['prompt' => '']); ?>
            <?= $form->field($model, 'languages')->widget(Select2::className(), [
                'data' => $model->available_languages,
                'showToggleAll' => false,
                'options' => [
                    'multiple' => true,
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>
        
        <div class="modal-footer">
            <?= Html::submitButton(
                Yii::t('app', 'Export'),
                ['class' => 'btn btn-primary btn-block']
            ) ?>
        </div>
        
        <?php ActiveForm::end(); ?>
    </div>
</div>
