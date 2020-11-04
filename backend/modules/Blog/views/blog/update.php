<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\web\JsExpression;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'update-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->sr->html->updateButtons(['save_reload', 'save']) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    <?= Yii::t('app', 'Information') ?>
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
            <div id="tab-information" class="tab-pane active">
                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                    'data' => [$model->category_id => ArrayHelper::getValue($model->category, 'name')],
                    'options' => [
                        'placeholder' => '',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['items-list/blog-categories']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]) ?>
                
                <?= $form->field($model, 'slug')->textInput() ?>
                <?= $form->field($model, 'published')->textInput(['data-toggle' => 'datetimepicker']) ?>
                <?= $form->field($model, 'image')->widget(ElFinderInput::className(), [
                    'connectorRoute' => '/connection/elfinder-file-upload',
                ]) ?>
                
                <?= $form->field($model, 'tags_tmp')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map($model->tags, 'id', 'name'),
                    'options' => [
                        'placeholder' => '',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'createTag' => new JsExpression('function(data) {
                            return {
                                id: data.term,
                                text: "' . Yii::t('app', 'Create') . ': " + data.term,
                                newTag: true
                            };
                        }'),
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['items-list/blog-tags']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
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
                        'deleteUrl' => Yii::$app->urlManager->createUrl(['blog/blog/image-delete', 'id' => $model->id, 'attr' => 'images']),
                        'initialPreview' => $model->images ?: [],
                        'initialPreviewConfig' => ArrayHelper::getColumn($model->images ?: [], function ($value) {
                            return ['key' => $value, 'downloadUrl' => $value];
                        }),
                    ]),
                    'pluginEvents' => [
                        'filesorted' => new JsExpression("function(event, params) {
                            $.post('".Yii::$app->urlManager->createUrl(['blog/blog/image-sort', 'id' => $model->id, 'attr' => 'images'])."', {sort: params});
                        }")
                    ],
                ]); ?>
            </div>
            
            <div id="tab-seo-meta" class="tab-pane fade">
                <?= $this->render('@backend/modules/Seo/views/meta/meta', [
                    'seo_meta' => Yii::$app->sr->seo->getMeta($model),
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
