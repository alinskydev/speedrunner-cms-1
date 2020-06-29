<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;

$this->title = Yii::t('app', 'System Settings');
$this->params['breadcrumbs'][] = $this->title;

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
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-general" class="tab-pane active">
                <ul id="sortable" class="p-0 m-0">
                    <?php foreach ($settings as $s) { ?>
                        <li class="d-flex mb-2" data-id="<?= $s->id ?>">
                            <div>
                                <label>&nbsp;</label><br>
                                <div class="btn btn-primary table-sorter">
                                    <i class="fas fa-arrows-alt"></i>
                                </div>
                            </div>
                            
                            <div class="col-5">
                                <?= $form->field($s, 'label')->textInput([
                                    'name' => 'SystemSettings['.$s->name.'][label]',
                                    'id' => 'systemsettings-label-' . $s->name,
                                ]) ?>
                            </div>
                            
                            <div class="col-6">
                                <?php
                                    switch ($s->type) {
                                        case 'textInput':
                                            echo $form->field($s, 'value')->textInput([
                                                'name' => "SystemSettings[$s->name][value]",
                                                'id' => "systemsettings-$s->name"
                                            ]);
                                            
                                            break;
                                        case 'textArea':
                                            echo $form->field($s, 'value')->textArea([
                                                'name' => "SystemSettings[$s->name][value]",
                                                'id' => "systemsettings-$s->name",
                                                'rows' => 5
                                            ]);
                                            
                                            break;
                                        case 'checkbox':
                                            echo Html::label('&nbsp;<br>') . $form->field($s, 'value', [
                                                'checkboxTemplate' => Yii::$app->params['switcher_template'],
                                            ])->checkbox([
                                                'name' => "SystemSettings[$s->name][value]",
                                                'id' => "systemsettings-$s->name",
                                                'class' => 'custom-control-input'
                                            ])->label(null, [
                                                'class' => 'custom-control-label'
                                            ]);
                                            
                                            break;
                                        case 'CKEditor':
                                            echo $form->field($s, 'value')->widget(Widget::className(), [
                                                'settings' => [
                                                    'imageUpload' => Yii::$app->urlManager->createUrl('connection/editor-image-upload'),
                                                    'imageManagerJson' => Yii::$app->urlManager->createUrl('connection/editor-images'),
                                                ],
                                                'options' => [
                                                    'name' => "SystemSettings[$s->name][value]",
                                                    'id' => "systemsettings-$s->name",
                                                ],
                                            ]);
                                            
                                            break;
                                        case 'ElFinder':
                                            echo $form->field($s, 'value')->widget(ElFinderInput::className(), [
                                                'connectorRoute' => '/connection/elfinder-file-upload',
                                                'name' => "SystemSettings[$s->name][value]",
                                                'id' => "systemsettings-$s->name",
                                            ]);
                                            
                                            break;
                                    }
                                ?>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<script>
    window.onload = function() {
        var id, oldIndex, newIndex, sendData,
            action = '<?= Yii::$app->urlManager->createUrl(['system/settings/sort']) ?>',
            token = $('meta[name=csrf-token]').attr('content');
        
        $('#sortable').sortable({
            handle: '.table-sorter',
            placeholder: 'sortable-placeholder mb-2',
            start: function(event, ui) {
                id = ui.item[0].dataset.id;
                oldIndex = ui.item.index();
            },
            stop: function(event, ui) {
                newIndex = ui.item.index();
                
                if (oldIndex !== newIndex) {
                    sendData = {
                        '_csrf-backend': token,
                        'id': id,
                        'oldIndex': oldIndex,
                        'newIndex': newIndex
                    };
                    
                    $.post(action, sendData);
                }
            }
        }).disableSelection();
    };
</script>
