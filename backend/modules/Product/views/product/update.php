<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use vova07\imperavi\Widget;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\web\JsExpression;

use backend\modules\Product\models\ProductCategory;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
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
                <a class="nav-link" data-toggle="pill" href="#tab-stock">
                    <?= Yii::t('app', 'Stock') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-images">
                    <?= Yii::t('app', 'Images') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-categories-specifications">
                    <?= Yii::t('app', 'Categories & Specifications') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-variations">
                    <?= Yii::t('app', 'Variations') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-related">
                    <?= Yii::t('app', 'Related') ?>
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
                <?= $form->field($model, 'slug')->textInput() ?>
                
                <?= $form->field($model, 'brand_id')->widget(Select2::classname(), [
                    'data' => [$model->brand_id => ArrayHelper::getValue($model->brand, 'name')],
                    'options' => [
                        'placeholder' => '',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['items-list/product-brands']),
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
            
            <div id="tab-stock" class="tab-pane fade">
                <?= $form->field($model, 'price')->textInput() ?>
                <?= $form->field($model, 'quantity')->textInput() ?>
                <?= $form->field($model, 'sku')->textInput() ?>
                <?= $form->field($model, 'sale')->textInput() ?>
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
                        'deleteUrl' => Yii::$app->urlManager->createUrl(['product/product/image-delete', 'id' => $model->id, 'attr' => 'images']),
                        'initialPreview' => $model->images ?: [],
                        'initialPreviewConfig' => ArrayHelper::getColumn($model->images ?: [], function ($value) {
                            return ['key' => $value, 'downloadUrl' => $value];
                        }),
                    ]),
                    'pluginEvents' => [
                        'filesorted' => new JsExpression("function(event, params) {
                            $.post('".Yii::$app->urlManager->createUrl(['product/product/image-sort', 'id' => $model->id, 'attr' => 'images'])."', {sort: params});
                        }")
                    ],
                ]); ?>
            </div>
            
            <div id="tab-categories-specifications" class="tab-pane fade">
                <?= $form->field($model, 'main_category_id')->dropDownList(ProductCategory::itemsTree([1]), [
                    'class' => 'form-control',
                    'data-toggle' => 'select2',
                    'prompt' => ' ',
                ]) ?>
                
                <?= $this->render('_categories', [
                    'model' => $model,
                    'form' => $form,
                    'data' => ProductCategory::findOne(1)->tree(),
                ]); ?>
            </div>
            
            <div id="tab-variations" class="tab-pane fade">
                <?= $this->render('_variations', [
                    'model' => $model,
                    'form' => $form,
                ]); ?>
            </div>
            
            <div id="tab-related" class="tab-pane fade">
                <?= $form->field($model, 'related_tmp')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map($model->related, 'id', 'name'),
                    'options' => [
                        'placeholder' => '',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['items-list/products', 'id' => $model->id]),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]) ?>
            </div>
            
            <div id="tab-seo-meta" class="tab-pane fade">
                <?= Yii::$app->sr->seo->getMetaLayout($model) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
