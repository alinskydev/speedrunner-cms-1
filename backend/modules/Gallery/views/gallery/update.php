<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\web\JsExpression;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'edit-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?php
        $buttons = [
            Html::button(
                Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save & reload'),
                ['class' => 'btn btn-info btn-icon', 'data-toggle' => 'save-reload']
            ),
            Html::submitButton(
                Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
                ['class' => 'btn btn-primary btn-icon']
            ),
        ];
        
        echo $this->title . Html::tag('div', implode(' ', $buttons), ['class' => 'float-right']);
    ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-general">
                    <?= Yii::t('app', 'General') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-images">
                    <?= Yii::t('app', 'Images') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-seo-meta">
                    <?= Yii::t('app', 'SEO meta') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-general" class="tab-pane active">
                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'slug')->textInput() ?>
            </div>
            
            <div id="tab-images" class="tab-pane fade">
                <?= $form->field($model, 'images', [
                    'template' => '{label}{error}{hint}{input}',
                ])->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true,
                    ],
                    'pluginOptions' => array_merge(Yii::$app->params['fileInput_pluginOptions'], [
                        'deleteUrl' => Yii::$app->urlManager->createUrl(['gallery/gallery/image-delete', 'id' => $model->id]),
                        'initialPreview' => $model->images ?: [],
                        'initialPreviewConfig' => ArrayHelper::getColumn($model->images ?: [], function ($value) {
                            return ['key' => $value, 'downloadUrl' => $value];
                        }),
                    ]),
                    'pluginEvents' => [
                        'filesorted' => new JsExpression("function(event, params) {
                            $.post('".Yii::$app->urlManager->createUrl(['gallery/gallery/image-sort', 'id' => $model->id])."', {sort: params});
                        }")
                    ],
                ]); ?>
            </div>
            
            <div id="tab-seo-meta" class="tab-pane fade">
                <?= Yii::$app->sr->seo->getMetaLayout($model) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
