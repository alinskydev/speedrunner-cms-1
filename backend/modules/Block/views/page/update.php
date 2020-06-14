<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;
use kartik\file\FileInput;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Block Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'edit-form', 'enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'enableClientValidation' => false,
        'template' => '{label}{input}{error}{hint}'
    ]
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
            <?php foreach ($blocks as $key => $b) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= !$key ? 'active' : null ?>" data-toggle="pill" href="#tab-block-<?= $b->id ?>">
                        <?= $b->type->label ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <?php foreach ($blocks as $key => $b) { ?>
                <div id="tab-block-<?= $b->id ?>" class="tab-pane <?= !$key ? 'active' : 'fade' ?>">
                    <?php
                        switch ($b->type->type) {
                            case 'textInput':
                                    echo $form->field($b, 'value')->textInput([
                                        'name' => "Block[$b->id][value]",
                                        'id' => "block-$b->id"
                                    ])->label($b->type->label);
                                    
                                    break;
                                case 'textArea':
                                    echo $form->field($b, 'value')->textArea([
                                        'name' => "Block[$b->id][value]",
                                        'id' => "block-$b->id",
                                        'rows' => 5
                                    ])->label($b->type->label);
                                    
                                    break;
                                case 'checkbox':
                                    echo $form->field($b, 'value', [
                                        'checkboxTemplate' => Yii::$app->params['switcher_template'],
                                    ])->checkbox([
                                        'name' => "Block[$b->id][value]",
                                        'id' => "block-$b->id",
                                        'class' => 'custom-control-input',
                                        'label' => null,
                                    ])->label($b->type->label, [
                                        'class' => 'custom-control-label'
                                    ]);
                                    
                                    break;
                                case 'CKEditor':
                                    echo $form->field($b, 'value')->widget(Widget::className(), [
                                        'settings' => [
                                            'imageUpload' => Yii::$app->urlManager->createUrl('connection/editor-image-upload'),
                                            'imageManagerJson' => Yii::$app->urlManager->createUrl('connection/editor-images'),
                                        ],
                                        'options' => [
                                            'name' => "Block[$b->id][value]",
                                            'id' => "block-$b->id",
                                        ],
                                    ])->label($b->type->label);
                                    
                                    break;
                                case 'ElFinder':
                                    echo $form->field($b, 'value')->widget(ElFinderInput::className(), [
                                        'connectorRoute' => '/connection/elfinder-file-upload',
                                        'name' => "Block[$b->id][value]",
                                        'id' => "block-$b->id",
                                    ])->label($b->type->label);
                                    
                                    break;
                                case 'images':
                                    echo $form->field($b, 'value', [
                                        'template' => '{label}{error}{hint}{input}',
                                    ])->widget(FileInput::className(), [
                                        'options' => [
                                            'accept' => 'image/*',
                                            'multiple' => true,
                                            'name' => "Block[$b->id][value][]",
                                            'id' => "block-$b->id",
                                        ],
                                        'pluginOptions' => array_merge(Yii::$app->params['fileInput_pluginOptions'], [
                                            'deleteUrl' => Yii::$app->urlManager->createUrl(['block/block/image-delete']),
                                            'initialPreview' => ArrayHelper::getColumn($b->images, 'image'),
                                            'initialPreviewConfig' => ArrayHelper::getColumn($b->images, function ($model) {
                                                return ['key' => $model['id'], 'downloadUrl' => $model['image']];
                                            }),
                                        ]),
                                        'pluginEvents' => [
                                            'filesorted' => new JsExpression('function(event, params){
                                                $.post("'.Yii::$app->urlManager->createUrl(["block/block/image-sort", "id" => $b->id]).'",{sort: params});
                                            }')
                                        ],
                                    ])->label($b->type->label);
                                    
                                    break;
                                case 'groups':
                                    echo $this->render('_groups', ['model' => $b, 'form' => $form]);
                                    break;
                        }
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
