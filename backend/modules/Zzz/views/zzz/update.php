<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;
use kartik\file\FileInput;

use backend\modules\Zzz\models\ZzzCategory;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zzzs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'edit-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::submitButton(
        Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>
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
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-general" class="tab-pane active">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'category_id')->dropDownList(
                    ArrayHelper::map(ZzzCategory::itemsList('name', 'translation'), 'id', 'text'),
                    [
                        'data-toggle' => 'selectpicker',
                        'prompt' => ' '
                    ]
                ) ?>
                
                <?= $form->field($model, 'image')->widget(ElFinderInput::className(), [
                    'connectorRoute' => '/connection/elfinder-file-upload',
                ]) ?>
                
                <?= $form->field($model, 'short_description')->textArea(['rows' => 5]); ?>
                <?= $form->field($model, 'full_description')->widget(Widget::className(), [
                    'settings' => [
                        'imageUpload' => Yii::$app->urlManager->createUrl('connection/editor-image-upload'),
                        'imageManagerJson' => Yii::$app->urlManager->createUrl('connection/editor-images'),
                    ],
                ]); ?>
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
                        'deleteUrl' => Yii::$app->urlManager->createUrl(['zzz/zzz/image-delete', 'id' => $model->id]),
                        'initialPreview' => $model->images ?: [],
                        'initialPreviewConfig' => ArrayHelper::getColumn($model->images ?: [], function ($value) {
                            return ['key' => $value, 'downloadUrl' => $value];
                        }),
                    ]),
                    'pluginEvents' => [
                        'filesorted' => new JsExpression("function(event, params) {
                            $.post('".Yii::$app->urlManager->createUrl(['zzz/zzz/image-sort', 'id' => $model->id])."', {sort: params});
                        }")
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
