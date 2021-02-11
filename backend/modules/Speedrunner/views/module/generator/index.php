<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->title = 'Module generator';
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
                <a class="nav-link" data-toggle="pill" href="#tab-controller">
                    Controller
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-model">
                    Model
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-view">
                    View
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-information" class="tab-pane active">
                <?= $form->field($model, 'module_name', ['enableClientValidation' => false])->textInput() ?>
                
                <?= $form->field($model, 'generate_files')->widget(Select2::classname(), [
                    'data' => $model->generateFiles,
                    'options' => [
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>
            </div>
            
            <div id="tab-controller" class="tab-pane fade">
                <?= $form->field($model, 'controller_name')->textInput() ?>
                
                <?= $form->field($model, 'controller_actions')->widget(Select2::classname(), [
                    'data' => $model->controllerActions,
                    'options' => [
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>
            </div>
            
            <div id="tab-model" class="tab-pane fade">
                <?= $form->field($model, 'table_name')->dropDownList($tables, [
                    'class' => 'form-control',
                    'data-toggle' => 'select2',
                    'prompt' => ' ',
                ]) ?>
                
                <?= $form->field($model, 'has_seo_meta', [
                    'checkboxTemplate' => Yii::$app->params['switcher_template'],
                ])->checkbox([
                    'class' => 'custom-control-input'
                ])->label(null, [
                    'class' => 'custom-control-label'
                ]) ?>
                
                <div id="generatorform-relations-result"></div>
                
                <?= $this->render('_view_relations', ['tables' => $tables]) ?>
            </div>
            
            <div id="tab-view" class="tab-pane fade">
                <div id="generatorform-attrs-result"></div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el, action, sendData;
        
        $('#generatorform-module_name').on('change', function() {
            $('#generatorform-table_name').val($(this).val()).trigger('change');
            $('#generatorform-controller_name').val($(this).val());
        });
        
        //        ------------------------------------------------
        
        function getModelSchema() {
            action = '<?= Yii::$app->urlManager->createUrl(['speedrunner/module/generator/model-schema']) ?>';
            sendData = {
                table_name: $('#generatorform-table_name').val()
            };
            
            $.get(action, sendData, function(data) {
                $('#generatorform-relations-result').html(data.relations);
                $('#generatorform-attrs-result').html(data.attrs);
            });
        }
        
        $('#generatorform-table_name').on('change', function() {
            getModelSchema();
        });
    });
</script>


<style>
    table th,
    table td {
        vertical-align: middle !important;
    }
</style>
