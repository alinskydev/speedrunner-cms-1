<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;
use kartik\select2\Select2;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'edit-form', 'enctype' => 'multipart/form-data'],
]); ?>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-general">
                    <?= Yii::t('app', 'General') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-attributes">
                    <?= Yii::t('app', 'Attributes') ?>
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
        <div class="main-shadow">
            <div class="p-3 bg-primary text-white d-flex align-items-center">
                <h5 class="m-0" style="flex: 1;">
                    <?= $this->title ?>
                </h5>
                
                <?php if (!$model->isNewRecord) { ?>
                    <?= Html::a(
                        Html::tag('i', null, ['class' => 'fas fa-external-link-alt']) . Yii::t('app', 'Link'),
                        Yii::$app->urlManagerFrontend->createUrl(['product/catalog', 'full_url' => $model->full_url]),
                        [
                            'class' => 'btn btn-info btn-icon float-right',
                            'target' => '_blank'
                        ]
                    ); ?>
                <?php } ?>
            </div>
            
            <div class="tab-content p-3">
                <div id="tab-general" class="tab-pane active">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'full_url', ['template' => '{error}'])->textInput() ?>
                    
                    <?= $form->field($model, 'image')->widget(ElFinderInput::className(), [
                        'connectorRoute' => '/connection/elfinder-file-upload',
                    ]) ?>
                    
                    <?= $form->field($model, 'description')->widget(Widget::className(), [
                        'settings' => [
                            'imageUpload' => Yii::$app->urlManager->createUrl('connection/editor-image-upload'),
                            'imageManagerJson' => Yii::$app->urlManager->createUrl('connection/editor-images'),
                        ],
                    ]); ?>
                    
                    <?php
                        if ($model->isNewRecord) {
                            echo $form->field($model, 'parent_id')->dropDownList($model->itemsTree(), [
                                'data-toggle' => 'selectpicker',
                            ]);
                        }
                    ?>
                </div>
                
                <div id="tab-attributes" class="tab-pane fade">
                    <?= $form->field($model, 'attrs_tmp')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($model->attrs, 'id', 'name'),
                        'options' => [
                            'placeholder' => '',
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags' => true,
                            'ajax' => [
                                'url' => Yii::$app->urlManager->createUrl(['product/attribute/items-list']),
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
            
            <div class="p-3">
                <?= Html::submitButton(
                    Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
                    ['class' => 'btn btn-primary btn-icon']
                ) ?>
                
                <?php
                    if (!$model->isNewRecord) {
                        $buttons = Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-trash']) . Yii::t('app', 'Delete'),
                            ['category/delete', 'id' => $model->id],
                            ['class' => 'btn btn-warning btn-icon']
                        ) . ' ';
                        
                        $buttons .= Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-trash']) . Yii::t('app', 'Delete with children'),
                            ['category/delete-with-children', 'id' => $model->id],
                            ['class' => 'btn btn-danger btn-icon']
                        );
                        
                        echo Html::tag('div', $buttons, ['class' => 'float-right']);
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
