<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use alexantr\elfinder\InputFile;
use vova07\imperavi\Widget;

$this->title = Yii::t('app', 'System settings');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'update-form'],
    'fieldConfig' => [
        'enableClientValidation' => false
    ]
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->services->html->saveButtons(['save']) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    <?= Yii::t('app', 'Information') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-information" class="tab-pane active">
                <ul id="sortable" class="p-0 m-0">
                    <?php foreach ($settings as $s) { ?>
                        <li class="d-flex p-3" data-id="<?= $s->id ?>">
                            <div class="mr-3">
                                <label>&nbsp;</label><br>
                                <div class="btn btn-primary table-sorter">
                                    <i class="fas fa-arrows-alt"></i>
                                </div>
                            </div>
                            
                            <div class="w-100">
                                <?php
                                    switch ($s->type) {
                                        case 'text_input':
                                            echo $form->field($s, 'value')->textInput([
                                                'name' => "SystemSettings[$s->id][value]",
                                                'id' => "systemsettings-$s->id",
                                            ])->label($s->label);
                                            
                                            break;
                                        case 'text_area':
                                            echo $form->field($s, 'value')->textArea([
                                                'name' => "SystemSettings[$s->id][value]",
                                                'id' => "systemsettings-$s->id",
                                                'rows' => 5,
                                            ])->label($s->label);
                                            
                                            break;
                                        case 'checkbox':
                                            echo Html::label('&nbsp;<br>') . $form->field($s, 'value', [
                                                'checkboxTemplate' => Yii::$app->params['switcher_template'],
                                            ])->checkbox([
                                                'name' => "SystemSettings[$s->id][value]",
                                                'id' => "systemsettings-$s->id",
                                                'class' => 'custom-control-input',
                                            ])->label($s->label, [
                                                'class' => 'custom-control-label',
                                            ]);
                                            
                                            break;
                                        case 'imperavi':
                                            echo $form->field($s, 'value')->widget(Widget::className(), [
                                                'options' => [
                                                    'name' => "SystemSettings[$s->id][value]",
                                                    'id' => "systemsettings-$s->id",
                                                ],
                                            ])->label($s->label);
                                            
                                            break;
                                        case 'elfinder':
                                            echo $form->field($s, 'value')->widget(InputFile::className(), [
                                                'options' => [
                                                    'name' => "SystemSettings[$s->id][value]",
                                                    'id' => "systemsettings-$s->id",
                                                ]
                                            ])->label($s->label);
                                            
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
    document.addEventListener('DOMContentLoaded', function() {
        let id, oldIndex, newIndex, sendData,
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
    });
</script>
