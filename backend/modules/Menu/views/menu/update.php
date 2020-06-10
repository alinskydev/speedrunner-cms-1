<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'edit-form', 'enctype' => 'multipart/form-data'],
]); ?>

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
        <div class="main-shadow">
            <div class="p-3 bg-primary text-white">
                <h5 class="m-0">
                    <?= $this->title ?>
                </h5>
            </div>
            
            <div class="tab-content p-3">
                <div id="tab-general" class="tab-pane active">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                    
                    <?php
                        if ($model->isNewRecord) {
                            echo $form->field($model, 'parent_id')->dropDownList($model->itemsList, [
                                'data-toggle' => 'selectpicker',
                            ]);
                        }
                    ?>
                </div>
            </div>
            
            <div class="p-3">
                <?= Html::submitButton(
                    Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
                    ['class' => 'btn btn-primary btn-icon']
                ) ?>
                
                <?php
                    if (!$model->isNewRecord) {
                        $buttons = Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-trash']) . Yii::t('app', 'Delete'),
                            ['menu/delete', 'id' => $model->id],
                            ['class' => 'btn btn-warning btn-icon']
                        ) . ' ';
                        
                        $buttons .= Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-trash']) . Yii::t('app', 'Delete with children'),
                            ['menu/delete-with-children', 'id' => $model->id],
                            ['class' => 'btn btn-danger btn-icon']
                        );
                        
                        echo Html::tag('div', $buttons, ['class' => 'float-right']);
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
