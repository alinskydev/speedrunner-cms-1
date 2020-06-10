<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use vova07\imperavi\Widget;
use kartik\file\FileInput;
use kartik\select2\Select2;

use backend\modules\Product\models\ProductCategory;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
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
                <a class="nav-link" data-toggle="pill" href="#tab-cats-attrs">
                    <?= Yii::t('app', 'Categories & Attributes') ?>
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
            <div id="tab-general" class="tab-pane active">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                
                <?= $form->field($model, 'is_active', [
                    'checkboxTemplate' => Yii::$app->params['switcher_template'],
                ])->checkbox([
                    'class' => 'custom-control-input'
                ])->label(null, [
                    'class' => 'custom-control-label'
                ]) ?>
                
                <?= $form->field($model, 'brand_id')->widget(Select2::classname(), [
                    'data' => $model->brand ? [$model->brand_id => $model->brand->name] : [],
                    'options' => [
                        'placeholder' => '',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['product/brand/get-selection-list']),
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
                <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'quantity')->textInput() ?>
                <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'sale')->textInput(['maxlength' => true]) ?>
            </div>
            
            <div id="tab-images" class="tab-pane fade">
                <?= $form->field($model, 'images_tmp', [
                    'template' => '{label}{error}{hint}{input}',
                ])->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true,
                    ],
                    'pluginOptions' => array_merge(Yii::$app->params['fileInput_pluginOptions'], [
                        'deleteUrl' => Yii::$app->urlManager->createUrl(['product/product/image-delete']),
                        'initialPreview' => ArrayHelper::getColumn($model->images, 'image'),
                        'initialPreviewConfig' => ArrayHelper::getColumn($model->images, function ($model) {
                            return ['key' => $model['id'], 'downloadUrl' => $model['image']];
                        }),
                    ]),
                    'pluginEvents' => [
                        'filesorted' => new JsExpression('function(event, params){
                            $.post("'.Yii::$app->urlManager->createUrl(["product/product/image-sort", "id" => $model->id]).'", {sort: params});
                        }')
                    ],
                ]); ?>
            </div>
            
            <div id="tab-cats-attrs" class="tab-pane fade">
                <?= $form->field($model, 'main_category_id')->dropDownList(ProductCategory::getItemsList([1]), [
                    'data-toggle' => 'selectpicker',
                    'prompt' => ' '
                ]) ?>
                
                <?= $this->render('_category_tree', [
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
                            'url' => Yii::$app->urlManager->createUrl(['product/product/get-selection-list', 'id' => $model->id]),
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


<script>
    window.onload = function() {
        var action = '<?= Yii::$app->urlManager->createUrl('product/product/get-attributes') ?>',
            receiveData, receiveJson, html, options;
        
        function getAttsFunc(categories) {
            sendData = {
                id: '<?= $model->id ? $model->id : 0 ?>',
                categories: categories
            };
            
            $.get(action, sendData, function(data) {
                receiveData = JSON.parse(data);
                receiveJson = receiveData.attrs_json;
                html = '';
                
                $('#attributes-inner').html(receiveData.attrs_html);
                
                for (i = 0; i < receiveJson.length; i++) {
                    html += '<option value="' + receiveJson[i]['id'] + '">' + receiveJson[i]['translation']['name'] + '</option>';
                }
                
                $('#vars-attr-list').html(html);
                changeAttrFunc($('#vars-attr-list').val());
            });
        };
        
        function changeAttrFunc(attrId) {
            html = '';
            
            for (i = 0; i < receiveJson.length; i++) {
                if (attrId == receiveJson[i]['id']) {
                    options = receiveJson[i]['options'];
                    
                    for (j = 0; j < options.length; j++) {
                        html += '<option value="' + options[j]['id'] + '">' + options[j]['translation']['value'] + '</option>';
                    }
                    
                    $('#vars-option-list').html(html);
                }
            }
        }
        
        getAttsFunc($('#product-cats_tmp').val());
        processVars();
        
        $('#product-cats_tmp').on('change', function() {
            getAttsFunc($(this).val());
        });
        
        $('#vars-attr-list').on('change', function() {
            changeAttrFunc($(this).val());
        });
    };
</script>
