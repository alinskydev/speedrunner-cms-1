<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use alexantr\elfinder\InputFile;

$this->title = 'Block generator';
$this->params['breadcrumbs'][] = ['label' => 'Speedrunner', 'url' => ['/speedrunner/speedrunner']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

$attr_input_types = Yii::$app->params['input_types'];
unset($attr_input_types['select'], $attr_input_types['select2_ajax']);

?>

<?php $form = ActiveForm::begin([
    'id' => 'update-form'
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::submitButton(
        Html::tag('i', null, ['class' => 'fas fa-file-code']) . 'Generate',
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    Information
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-information" class="tab-pane active">
                <table class="table table-relations">
                    <thead>
                        <tr>
                            <th style="width: 3%;"></th>
                            <th style="width: 15%;">Name</th>
                            <th style="width: 15%;">Label</th>
                            <th style="width: 4%;">I18N</th>
                            <th style="width: 15%;">Input type</th>
                            <th style="width: 30%;">Attrs (for "groups" input type)</th>
                            <th style="width: 15%;">Image</th>
                            <th style="width: 3%;"></th>
                        </tr>
                    </thead>
                    
                    <tbody data-sr-tirgger="sortable">
                        <tr class="table-new-relation" data-table="blocks">
                            <td>
                                <div class="btn btn-primary table-sorter">
                                    <i class="fas fa-arrows-alt"></i>
                                </div>
                            </td>
                            
                            <td>
                                <?= Html::input('text', 'GeneratorForm[blocks][__key__][name]', null, ['class' => 'form-control', 'required' => true]); ?>
                            </td>
                            
                            <td>
                                <?= Html::input('text', 'GeneratorForm[blocks][__key__][label]', null, ['class' => 'form-control', 'required' => true]); ?>
                            </td>
                            
                            <td>
                                <div class="custom-control custom-switch">
                                    <?php
                                        echo Html::checkbox('GeneratorForm[blocks][__key__][has_translation]', null, [
                                            'uncheck' => 0,
                                            'id' => 'generatorform-__key__',
                                            'class' => 'custom-control-input',
                                        ]);
                                        
                                        echo Html::label(null, 'generatorform-__key__', ['class' => 'custom-control-label']);
                                    ?>
                                </div>
                            </td>
                            
                            <td>
                                <?= Html::dropdownList(
                                    'GeneratorForm[blocks][__key__][input_type]',
                                    null,
                                    $attr_input_types,
                                    ['class' => 'form-control']
                                ); ?>
                            </td>
                            
                            <td>
                                <div class="block-attrs-wrap"></div>
                                
                                <button type="button"
                                        class="btn btn-success btn-block btn-attr-add"
                                        data-action="<?= Yii::$app->urlManager->createUrl(['speedrunner/block/generator/new-attr', 'block' => '__key__']) ?>"
                                >
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                            
                            <td>
                                <?= Html::tag(
                                    'div',
                                    InputFile::widget([
                                        'id' => "elfinder-__key__",
                                        'name' => 'GeneratorForm[blocks][__key__][image]',
                                        'options' => [
                                            'required' => true,
                                            'style' => 'border: 0; width: 1px; position: absolute; z-index: -1; left: 50%;'
                                        ]
                                    ]),
                                    ['data-sr-trigger' => 'file_manager']
                                ); ?>
                            </td>
                            
                            <td>
                                <button type="button" class="btn btn-danger btn-remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <button type="button" class="btn btn-success btn-block btn-add" data-table="blocks">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let el, action, sendData;
        
        $(document).on('click', '.btn-attr-add', function() {
            el = $(this);
            action = el.data('action');
            
            $.get(action, {}, function(data) {
                el.closest('td').find('.block-attrs-wrap').append(data);
            });
        });
        
        $(document).on('click', '.btn-attr-remove', function() {
            $(this).closest('.block-attrs').remove();
        });
    });
</script>


<style>
    table th,
    table td {
        vertical-align: middle !important;
    }
</style>
