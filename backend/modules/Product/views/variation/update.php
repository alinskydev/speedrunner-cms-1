<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use yii\web\JsExpression;

$this->title = Yii::t('app', 'Variation: {value}', ['value' => $model->id]);

?>

<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <?php $form = ActiveForm::begin([
            'options' => [
                'id' => 'update-form',
                'data-toggle' => 'ajax-form',
                'data-el' => '#main-modal',
            ],
        ]); ?>
        
        <div class="modal-header">
            <h4 class="modal-title"><?= $this->title ?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <ul class="nav flex-column nav-pills main-shadow" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#tab-variations-information">
                                <?= Yii::t('app', 'Information') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tab-variations-images">
                                <?= Yii::t('app', 'Images') ?>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
                    <div class="tab-content main-shadow p-3">
                        <div id="tab-variations-information" class="tab-pane active">
                            <?= $form->field($model, 'price')->textInput() ?>
                            <?= $form->field($model, 'quantity')->textInput() ?>
                            <?= $form->field($model, 'sku')->textInput() ?>
                        </div>
                        
                        <div id="tab-variations-images" class="tab-pane fade">
                            <?= $form->field($model, 'images', [
                                'template' => '{label}{hint}{error}{input}',
                            ])->widget(FileInput::classname(), [
                                'options' => [
                                    'accept' => 'image/*',
                                    'multiple' => true,
                                ],
                                'pluginOptions' => array_merge(Yii::$app->params['fileInput_pluginOptions'], [
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
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal-footer">
            <?= Html::submitButton(
                Yii::t('app', 'Save'),
                ['class' => 'btn btn-primary btn-block float-right']
            ) ?>
        </div>
        
        <?php ActiveForm::end(); ?>
    </div>
</div>
