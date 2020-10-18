<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'update-form',
        'data-toggle' => 'ajax-form',
        'data-el' => '#nav-item-content',
        'enctype' => 'multipart/form-data',
    ],
]); ?>

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
        <div class="main-shadow">
            <div class="p-3 bg-primary text-white">
                <h5 class="m-0">
                    <?= $this->title ?>
                </h5>
            </div>
            
            <div class="tab-content p-3">
                <div id="tab-information" class="tab-pane active">
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'url')->textInput() ?>
                    
                    <?php
                        if ($model->isNewRecord) {
                            echo $form->field($model, 'parent_id')->dropDownList($model->itemsTree(), [
                                'class' => 'form-control',
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
                        $buttons[] = Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-trash']) . Yii::t('app', 'Delete'),
                            ['menu/delete', 'id' => $model->id],
                            ['class' => 'btn btn-warning btn-icon']
                        ) . ' ';
                        
                        $buttons[] = Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-trash']) . Yii::t('app', 'Delete with children'),
                            ['menu/delete-with-children', 'id' => $model->id],
                            ['class' => 'btn btn-danger btn-icon']
                        );
                        
                        echo Html::tag('div', implode(null, $buttons), ['class' => 'float-right']);
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
