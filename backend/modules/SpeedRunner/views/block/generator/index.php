<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use zxbodya\yii2\elfinder\ElFinderInput;

$this->title = 'Block generator';
$this->params['breadcrumbs'][] = ['label' => 'Speedrunner', 'url' => ['/speedrunner/speedrunner']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'id' => 'update-form'
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::submitButton(
        Html::tag('i', null, ['class' => 'fas fa-file-code']) . Yii::t('speedrunner', 'Generate'),
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    <?= Yii::t('speedrunner', 'General') ?>
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
                            <th style="width: 15%;"><?= Yii::t('speedrunner', 'Name') ?></th>
                            <th style="width: 15%;"><?= Yii::t('speedrunner', 'Label') ?></th>
                            <th style="width: 4%;"><?= Yii::t('speedrunner', 'I18N') ?></th>
                            <th style="width: 15%;"><?= Yii::t('speedrunner', 'Type') ?></th>
                            <th style="width: 30%;"><?= Yii::t('speedrunner', 'Attrs (for "groups" type)') ?></th>
                            <th style="width: 15%;"><?= Yii::t('speedrunner', 'Image') ?></th>
                            <th style="width: 3%;"></th>
                        </tr>
                    </thead>
                    
                    <tbody data-toggle="sortable">
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
                                    'GeneratorForm[blocks][__key__][type]',
                                    null,
                                    Yii::$app->params['input_types'],
                                    ['class' => 'form-control']
                                ); ?>
                            </td>
                            
                            <td>
                                <div class="block-attrs-wrap"></div>
                                
                                <button type="button"
                                        class="btn btn-success btn-block btn-attr-add"
                                        data-action="<?= Yii::$app->urlManager->createUrl(['speedrunner/block/generator/new-attr', 'block' => '__key__']) ?>"
                                >
                                    <i class="fa fa-plus"></i>
                                </button>
                            </td>
                            
                            <td>
                                <?= ElFinderInput::widget([
                                    'connectorRoute' => '/connection/elfinder-file-upload',
                                    'name' => 'GeneratorForm[blocks][__key__][image]',
                                    'id' => "elfinder-__key__",
                                    'inputOptions' => [
                                        'required' => true,
                                        'style' => 'border: 0; width: 1px; position: absolute; z-index: -1; left: 50%;'
                                    ]
                                ]); ?>
                            </td>
                            
                            <td>
                                <button type="button" class="btn btn-danger btn-remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <button type="button" class="btn btn-success btn-block btn-add" data-table="blocks">
                                    <i class="fa fa-plus"></i>
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
        var el, action, sendData;
        
        $(document).on('click', '.btn-attr-add', function() {
            el = $(this);
            action = el.data('action');
            
            $.get(action, {}, function(data) {
                el.parents('td').find('.block-attrs-wrap').append(data);
            });
        });
        
        $(document).on('click', '.btn-attr-remove', function() {
            $(this).parents('.block-attrs').remove();
        });
    });
</script>


<style>
    table th,
    table td {
        vertical-align: middle !important;
    }
</style>
