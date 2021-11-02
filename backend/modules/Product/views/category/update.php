<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use alexantr\elfinder\InputFile;
use alexantr\tinymce\TinyMCE;
use kartik\select2\Select2;
use yii\web\JsExpression;

use speedrunner\widgets\TranslationActiveField;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {value}', ['value' => $model->id]);

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'update-form',
        'data-sr-trigger' => 'ajax-form',
        'data-sr-wrapper' => '#nav-item-content',
    ],
]); ?>

<div class="row">
    <div class="col-lg-3 col-md-4">
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
    
    <div class="col-lg-9 col-md-8 mt-3 mt-md-0">
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
                    <?= $form->field($model, 'name', ['class' => TranslationActiveField::className()])->textInput() ?>
                    <?= $form->field($model, 'slug')->textInput() ?>
                    <?= $form->field($model, 'image')->widget(InputFile::className()) ?>
                    <?= $form->field($model, 'description', ['class' => TranslationActiveField::className()])->widget(TinyMCE::className()) ?>
                    
                    <?php
                        if ($model->isNewRecord) {
                            echo $form->field($model, 'parent_id')->dropDownList(
                                ArrayHelper::map($parents, 'id', 'text'),
                                [
                                    'class' => 'form-control',
                                    'data-sr-trigger' => 'select2',
                                ]
                            );
                        }
                    ?>
                </div>
                
                <div id="tab-specifications" class="tab-pane fade">
                    <?= $form->field($model, 'specifications_tmp')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($model->specifications, 'id', 'name'),
                        'options' => [
                            'placeholder' => '',
                            'multiple' => true,
                            'value' => ArrayHelper::getColumn($model->specifications, 'id'),
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
                        'model' => $model,
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
                            ['delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-warning btn-icon',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure?'),
                                    'method' => 'post',
                                ]
                            ]
                        );
                        
                        $buttons[] = Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-trash']) . Yii::t('app', 'Delete with children'),
                            ['delete-with-children', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger btn-icon',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure?'),
                                    'method' => 'post',
                                ]
                            ]
                        );
                        
                        echo Html::tag('div', implode(' ', $buttons), ['class' => 'float-right']);
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
