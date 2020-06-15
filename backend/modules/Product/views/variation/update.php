<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use yii\web\JsExpression;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {id}', ['id' => $model->id]);

?>

<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <?php $form = ActiveForm::begin([
            'options' => ['id' => 'vars-edit-form', 'enctype' => 'multipart/form-data'],
        ]); ?>
        
        <div class="modal-header">
            <h4 class="modal-title"><?= $this->title ?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <ul class="nav flex-column nav-pills" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#tab-vars-general">
                                <?= Yii::t('app', 'General') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tab-vars-images">
                                <?= Yii::t('app', 'Images') ?>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
                    <div class="tab-content p-3">
                        <div id="tab-vars-general" class="tab-pane active">
                            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>
                        </div>
                        
                        <div id="tab-vars-images" class="tab-pane fade">
                            <?= $form->field($model, 'images', [
                                'template' => '{label}{error}{hint}{input}',
                            ])->widget(FileInput::classname(), [
                                'options' => [
                                    'accept' => 'image/*',
                                    'multiple' => true,
                                ],
                                'pluginOptions' => array_merge(Yii::$app->params['fileInput_pluginOptions'], [
                                    'deleteUrl' => Yii::$app->urlManager->createUrl(['product/variation/image-delete', 'id' => $model->id]),
                                    'initialPreview' => $model->images ?: [],
                                    'initialPreviewConfig' => ArrayHelper::getColumn($model->images ?: [], function ($value) {
                                        return ['key' => $value, 'downloadUrl' => $value];
                                    }),
                                ]),
                                'pluginEvents' => [
                                    'filesorted' => new JsExpression("function(event, params) {
                                        $.post('".Yii::$app->urlManager->createUrl(['product/variation/image-sort', 'id' => $model->id])."', {sort: params});
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
