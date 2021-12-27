<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use alexantr\elfinder\InputFile;
use alexantr\tinymce\TinyMCE;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\web\JsExpression;

?>

<?php $form = ActiveForm::begin(
    ArrayHelper::merge(
        [
            'options' => [
                'id' => 'update-form',
                'enctype' => 'multipart/form-data',
            ],
        ],
        $form_options
    )
); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->helpers->html->saveButtons($save_buttons) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <?php foreach ($tabs as $tab_key => $tab) { ?>
                <li class="nav-item">
                    <?= Html::a($tab['label'], "#tab-$tab_key", [
                        'class' => 'nav-link ' . ($tab_key == array_key_first($tabs) ? 'active' : null),
                        'data-toggle' => 'pill',
                    ]) ?>
                </li>
            <?php } ?>
            
            <?php if ($has_seo_meta) { ?>
                <li class="nav-item">
                    <?= Html::a(Yii::t('app', 'SEO meta'), '#tab-seo-meta', [
                        'class' => 'nav-link ' . (!$tabs ? 'active' : null),
                        'data-toggle' => 'pill',
                    ]) ?>
                </li>
            <?php } ?>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <?php foreach ($tabs as $tab_key => $tab) { ?>
                <div id="tab-<?= $tab_key ?>" class="tab-pane <?= $tab_key == array_key_first($tabs) ? 'active' : 'fade' ?>">
                    <?php
                        foreach ($tab['attributes'] as $key => $attribute) {
                            $name = is_array($attribute) ? $attribute['name'] : $key;
                            $type = is_array($attribute) ? $attribute['type'] : $attribute;
                            
                            switch ($type) {
                                case 'text_input':
                                    echo $form->field(
                                        $model, $name,
                                        ArrayHelper::getValue($attribute, 'container_options', [])
                                    )->textInput(
                                        ArrayHelper::getValue($attribute, 'options', [])
                                    );
                                    break;
                                    
                                case 'text_area':
                                    echo $form->field(
                                        $model, $name,
                                        ArrayHelper::getValue($attribute, 'container_options', [])
                                    )->textArea(
                                        ArrayHelper::merge(
                                            ['rows' => 5],
                                            ArrayHelper::getValue($attribute, 'options', [])
                                        )
                                    );
                                    break;
                                    
                                case 'checkbox':
                                    echo $form->field(
                                        $model, $name,
                                        ArrayHelper::getValue($attribute, 'container_options', [])
                                    )->checkbox(
                                        ArrayHelper::merge(
                                            ['class' => 'custom-control-input'],
                                            ArrayHelper::getValue($attribute, 'options', [])
                                        )
                                    )->label(null, ['class' => 'custom-control-label']);
                                    break;
                                    
                                case 'select':
                                    echo $form->field(
                                        $model, $name,
                                        ArrayHelper::getValue($attribute, 'container_options', [])
                                    )->dropDownList(
                                        ArrayHelper::getValue($attribute, 'data', []),
                                        ArrayHelper::getValue($attribute, 'options', [])
                                    );
                                    break;
                                    
                                case 'select2_ajax':
                                    echo $form->field(
                                        $model, $name,
                                        ArrayHelper::getValue($attribute, 'container_options', [])
                                    )->widget(
                                        Select2::className(),
                                        ArrayHelper::merge(
                                            [
                                                'data' => ArrayHelper::getValue($attribute, 'data', []),
                                                'options' => [
                                                    'placeholder' => '',
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'tags' => ArrayHelper::getValue($attribute, 'widget_options.tags', false),
                                                    'ajax' => [
                                                        'url' => ArrayHelper::getValue($attribute, 'widget_options.ajax_url'),
                                                        'dataType' => 'json',
                                                        'delay' => 300,
                                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                                    ],
                                                ],
                                            ],
                                            ArrayHelper::getValue($attribute, 'options', [])
                                        )
                                    );
                                    break;
                                    
                                case 'file_manager':
                                    echo $form->field(
                                        $model, $name,
                                        ArrayHelper::getValue($attribute, 'container_options', [])
                                    )->widget(
                                        InputFile::className(),
                                        ArrayHelper::getValue($attribute, 'options', [])
                                    );
                                    break;
                                    
                                case 'text_editor':
                                    echo $form->field(
                                        $model, $name,
                                        ArrayHelper::getValue($attribute, 'container_options', [])
                                    )->widget(
                                        TinyMCE::className(),
                                        ArrayHelper::getValue($attribute, 'options', [])
                                    );
                                    break;
                                    
                                case 'files':
                                    $multiple = ArrayHelper::getValue($attribute, 'multiple', false);
                                    $files = ArrayHelper::getValue($attribute, 'value', $model->{$name});
                                    
                                    $initial_preview = $multiple ? ($files ?? []) : ($files ?? '');
                                    $initial_preview_config = $multiple ? (
                                        ArrayHelper::getColumn($files ?? [], function($value) {
                                            $file = Yii::getAlias("@frontend/web$value");
                                            $widget_filetype = is_file($file) ? mime_content_type($file) : 'other';
                                            $widget_type = explode('/', $widget_filetype)[0];
                                            
                                            return [
                                                'key' => $value,
                                                'downloadUrl' => $value,
                                                'type' => $widget_type,
                                                'filetype' => $widget_filetype,
                                            ];
                                        })
                                    ) : [];
                                    
                                    echo $form->field(
                                        $model, $name,
                                        ArrayHelper::merge(
                                            ['template' => '{label}{hint}{error}{input}'],
                                            ArrayHelper::getValue($attribute, 'container_options', [])
                                        )
                                    )->widget(
                                        FileInput::className(),
                                        ArrayHelper::merge(
                                            [
                                                'options' => [
                                                    'accept' => 'image/*',
                                                    'multiple' => $multiple,
                                                ],
                                                'pluginOptions' => array_merge(Yii::$app->params['fileInput_plugin_options'], [
                                                    'deleteUrl' => ArrayHelper::getValue($attribute, 'widget_options.delete_url'),
                                                    'initialPreview' => $initial_preview,
                                                    'initialPreviewConfig' => $initial_preview_config,
                                                ]),
                                                'pluginEvents' => [
                                                    'filesorted' => $multiple ? new JsExpression("function(event, params) {
                                                        $.post('" . ArrayHelper::getValue($attribute, 'widget_options.sort_url', []) . "', {sort: params});
                                                    }") : 'false',
                                                ],
                                            ],
                                            ArrayHelper::getValue($attribute, 'options', [])
                                        )
                                    );
                                    break;
                                    
                                case 'render':
                                    echo $this->render(
                                        ArrayHelper::getValue($attribute, 'view'),
                                        ArrayHelper::merge(
                                            [
                                                'model' => ArrayHelper::getValue($attribute, 'model', $model),
                                                'form' => $form,
                                            ],
                                            ArrayHelper::getValue($attribute, 'params', []),
                                        ),
                                        Yii::$app->controller
                                    );
                                    break;
                                    
                                default:
                                    echo $attribute;
                            }
                        }
                    ?>
                </div>
            <?php } ?>
            
            <?php if ($has_seo_meta) { ?>
                <div id="tab-seo-meta" class="tab-pane <?= !$tabs ? 'active' : 'fade' ?>">
                    <?= $this->render('@backend/modules/Seo/views/meta/meta', [
                        'model' => $seo_meta_model,
                    ]) ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
