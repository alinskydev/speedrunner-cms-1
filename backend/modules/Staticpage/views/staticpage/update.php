<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;
use kartik\file\FileInput;

$this->title = Yii::t('app', 'Static page: {location}', ['location' => ucfirst($model->location)]);
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'update-form', 'enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'enableClientValidation' => false
    ]
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->sr->html->updateButtons(['save']) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <?php $counter = 0 ?>
            <?php foreach ($blocks as $key => $b) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= !$counter ? 'active' : null ?>" data-toggle="pill" href="#tab-page-<?= $b[0]->part_index ?>">
                        <?= $key ?>
                    </a>
                </li>
                
                <?php $counter++ ?>
            <?php } ?>
            
            <?php if ($model->has_seo_meta) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= !$blocks ? 'active' : null ?>" data-toggle="pill" href="#tab-page-seo-meta">
                        <?= Yii::t('app', 'SEO meta') ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <?php $counter = 0 ?>
            <?php foreach ($blocks as $key => $block_part) { ?>
                <div id="tab-page-<?= $block_part[0]->part_index ?>" class="tab-pane <?= !$counter ? 'active' : 'fade' ?>">
                    <?php foreach ($block_part as $b) { ?>
                        <?php
                            switch ($b->type) {
                                case 'textInput':
                                    echo $form->field($b, 'value')->textInput([
                                        'name' => "StaticpageBlock[$b->id][value]",
                                        'id' => "staticpageblock-$b->id",
                                    ])->label(Yii::t('app', $b->label));
                                    
                                    break;
                                case 'textArea':
                                    echo $form->field($b, 'value')->textArea([
                                        'name' => "StaticpageBlock[$b->id][value]",
                                        'id' => "staticpageblock-$b->id",
                                        'rows' => 5,
                                    ])->label(Yii::t('app', $b->label));
                                    
                                    break;
                                case 'checkbox':
                                    echo $form->field($b, 'value', [
                                        'checkboxTemplate' => Yii::$app->params['switcher_template'],
                                    ])->checkbox([
                                        'name' => "StaticpageBlock[$b->id][value]",
                                        'id' => "staticpageblock-$b->id",
                                        'class' => 'custom-control-input',
                                        'label' => null,
                                    ])->label(Yii::t('app', $b->label), [
                                        'class' => 'custom-control-label',
                                    ]);
                                    
                                    break;
                                case 'CKEditor':
                                    echo $form->field($b, 'value')->widget(Widget::className(), [
                                        'settings' => [
                                            'imageUpload' => Yii::$app->urlManager->createUrl('connection/editor-image-upload'),
                                            'imageManagerJson' => Yii::$app->urlManager->createUrl('connection/editor-images'),
                                        ],
                                        'options' => [
                                            'name' => "StaticpageBlock[$b->id][value]",
                                            'id' => "staticpageblock-$b->id",
                                        ],
                                    ])->label(Yii::t('app', $b->label));
                                    
                                    break;
                                case 'ElFinder':
                                    echo $form->field($b, 'value')->widget(ElFinderInput::className(), [
                                        'connectorRoute' => '/connection/elfinder-file-upload',
                                        'name' => "StaticpageBlock[$b->id][value]",
                                        'id' => "staticpageblock-$b->id",
                                    ])->label(Yii::t('app', $b->label));
                                    
                                    break;
                                case 'images':
                                    echo $form->field($b, 'value', [
                                        'template' => '{label}{error}{hint}{input}',
                                    ])->widget(FileInput::className(), [
                                        'options' => [
                                            'accept' => 'image/*',
                                            'multiple' => true,
                                            'name' => "StaticpageBlock[$b->id][value][]",
                                            'id' => "staticpageblock-$b->id",
                                        ],
                                        'pluginOptions' => array_merge(Yii::$app->params['fileInput_pluginOptions'], [
                                            'deleteUrl' => Yii::$app->urlManager->createUrl(['staticpage/staticpage/image-delete', 'id' => $b->id]),
                                            'initialPreview' => $b->value ?: [],
                                            'initialPreviewConfig' => ArrayHelper::getColumn($b->value ?: [], function ($value) {
                                                return ['key' => $value, 'downloadUrl' => $value];
                                            }),
                                        ]),
                                        'pluginEvents' => [
                                            'filesorted' => new JsExpression("function(event, params) {
                                                $.post('".Yii::$app->urlManager->createUrl(['staticpage/staticpage/image-sort', 'id' => $b->id])."', {sort: params});
                                            }")
                                        ],
                                    ])->label(Yii::t('app', $b->label));
                                    
                                    break;
                                case 'groups':
                                    echo $this->render('_groups', ['model' => $b, 'form' => $form]);
                                    break;
                            }
                        ?>
                    <?php } ?>
                </div>
                
                <?php $counter++ ?>
            <?php } ?>
            
            <?php if ($model->has_seo_meta) { ?>
                <div id="tab-page-seo-meta" class="tab-pane <?= !$blocks ? 'active' : 'fade' ?>">
                    <?= $this->render('@backend/modules/Seo/views/meta/meta', [
                        'seo_meta' => Yii::$app->sr->seo->getMeta($model),
                    ]) ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
