<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;
use kartik\select2\Select2;
use yii\web\JsExpression;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'update-form',
        'data-toggle' => 'ajax-form',
        'data-el' => '#nav-item-content',
        'enctype' => 'multipart/form-data',
    ],
]); ?>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    <?= Yii::t('app', 'Information') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-specifications">
                    <?= Yii::t('app', 'Specifications') ?>
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
                        Yii::$app->urlManagerFrontend->createUrl(['product/catalog', 'url' => $model->url()]),
                        [
                            'class' => 'btn btn-info btn-icon float-right',
                            'target' => '_blank'
                        ]
                    ); ?>
                <?php } ?>
            </div>
            
            <div class="tab-content p-3">
                <div id="tab-information" class="tab-pane active">
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'slug')->textInput() ?>
                    
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
                                'class' => 'form-control',
                                'data-toggle' => 'select2',
                            ]);
                        }
                    ?>
                </div>
                
                <div id="tab-specifications" class="tab-pane fade">
                    <?= $form->field($model, 'specifications_tmp')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($model->specifications, 'id', 'name'),
                        'options' => [
                            'placeholder' => '',
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags' => true,
                            'ajax' => [
                                'url' => Yii::$app->urlManager->createUrl(['items-list/product-specifications']),
                                'dataType' => 'json',
                                'delay' => 300,
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ]) ?>
                </div>
                
                <div id="tab-seo-meta" class="tab-pane fade">
                <?= $this->render('@backend/modules/Seo/views/meta/meta', [
                    'seo_meta' => Yii::$app->sr->seo->getMeta($model),
                ]) ?>
                </div>
            </div>
            
            <div class="p-3">
                <?= Html::submitButton(
                    Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
                    ['class' => 'btn btn-primary btn-icon']
                ) ?>
                
                <?php
                    if (!$model->isNewRecord) {
                        $buttons[] = Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-trash']) . Yii::t('app', 'Delete'),
                            ['category/delete', 'id' => $model->id],
                            ['class' => 'btn btn-warning btn-icon']
                        ) . ' ';
                        
                        $buttons[] = Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-trash']) . Yii::t('app', 'Delete with children'),
                            ['category/delete-with-children', 'id' => $model->id],
                            ['class' => 'btn btn-danger btn-icon']
                        );
                        
                        echo Html::tag('div', implode(null, $buttons), ['class' => 'float-right']);
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
