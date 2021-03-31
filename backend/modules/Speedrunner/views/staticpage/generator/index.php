<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->title = 'Static page generator';
$this->params['breadcrumbs'][] = ['label' => 'Speedrunner', 'url' => ['/speedrunner/speedrunner']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

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
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-blocks">
                    Blocks
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-information" class="tab-pane active">
                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'label')->textInput() ?>
                
                <?= $form->field($model, 'has_seo_meta')->checkbox([
                    'class' => 'custom-control-input'
                ])->label(null, [
                    'class' => 'custom-control-label'
                ]) ?>
            </div>
            
            <div id="tab-blocks" class="tab-pane fade">
                <?= $this->render('_parts') ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let el, action, sendData,
            partIndex = 0;
        
        $(document).on('click', '.btn-part-add', function() {
            el = $(this);
            action = el.data('action');
            
            sendData = {
                part_name: $('.part-name').val(),
                part_index: partIndex
            };
            
            $.get(action, sendData, function(data) {
                $('#tab-blocks').append(data);
                partIndex++;
            });
        });
        
        $(document).on('click', '.btn-part-remove', function() {
            $(this).closest('.part').remove();
            partIndex--;
        });
        
        //        ------------------------------------------------
        
        $(document).on('click', '.btn-block-add', function() {
            el = $(this);
            action = el.data('action');
            
            sendData = {
                part_name: el.data('part_name'),
                part_index: el.data('part_index')
            };
            
            $.get(action, sendData, function(data) {
                el.closest('table').find('tbody').append(data);
            });
        });
        
        $(document).on('click', '.btn-block-remove', function() {
            $(this).closest('tr').remove();
        });
        
        //        ------------------------------------------------
        
        $(document).on('click', '.btn-attr-add', function() {
            el = $(this);
            action = el.data('action');
            
            $.get(action, {}, function(data) {
                el.closest('td').find('.page-attrs-wrap').append(data);
            });
        });
        
        $(document).on('click', '.btn-attr-remove', function() {
            $(this).closest('.page-attrs').remove();
        });
    });
</script>


<style>
    table th,
    table td {
        vertical-align: middle !important;
    }
</style>
