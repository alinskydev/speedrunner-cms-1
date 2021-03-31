<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use yii\web\JsExpression;

?>

<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <?php $form = ActiveForm::begin([
            'options' => [
                'id' => 'update-form',
                'data-sr-trigger' => 'ajax-form',
                'data-sr-wrapper' => '#main-modal',
                'data-sr-callback' => 'data.length === 0 ? $("#main-modal").modal("hide") : null',
            ],
        ]); ?>
        
        <div class="modal-header">
            <h4 class="modal-title">
                <?= Yii::t('app', 'Variation: {value}', ['value' => $model->id]) ?>
            </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
            <?= $form->field($model, 'images', [
                'template' => '{label}{hint}{error}{input}',
            ])->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ],
                'pluginOptions' => array_merge(Yii::$app->params['fileInput_plugin_options'], [
                    'deleteUrl' => Yii::$app->urlManager->createUrl(['product/variation/file-delete', 'id' => $model->id, 'attr' => 'images']),
                    'initialPreview' => $model->images ?? [],
                    'initialPreviewConfig' => ArrayHelper::getColumn($model->images ?? [], fn ($value) => ['key' => $value, 'downloadUrl' => $value]),
                ]),
                'pluginEvents' => [
                    'filesorted' => new JsExpression("function(event, params) {
                        $.post('".Yii::$app->urlManager->createUrl(['product/variation/file-sort', 'id' => $model->id, 'attr' => 'images'])."', {sort: params});
                    }")
                ],
            ]); ?>
        </div>
        
        <div class="modal-footer">
            <?= Html::submitButton(
                Yii::t('app', 'Save'),
                ['class' => 'btn btn-primary btn-block']
            ) ?>
        </div>
        
        <?php ActiveForm::end(); ?>
    </div>
</div>
