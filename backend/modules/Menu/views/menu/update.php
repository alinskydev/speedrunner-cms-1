<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {value}', ['value' => $model->name]);

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'update-form',
        'data-sr-trigger' => 'ajax-form',
        'data-sr-wrapper' => '#nav-item-content',
    ],
]); ?>

<div class="row">
    <div class="col-lg-3 col-md-4">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    <?= Yii::t('app', 'Information') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-9 col-md-8 mt-3 mt-md-0">
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
                            echo $form->field($model, 'parent_id')->dropDownList(
                                ArrayHelper::map($menu_list, 'id', 'text'),
                                [
                                    'class' => 'form-control',
                                    'data-toggle' => 'select2',
                                ]
                            );
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
                            ['delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-warning btn-icon',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure?'),
                                    'method' => 'post',
                                ]
                            ]
                        );
                        
                        $buttons[] = Html::a(
                            Html::tag('i', null, ['class' => 'fas fa-trash']) . Yii::t('app', 'Delete with children'),
                            ['delete-with-children', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger btn-icon',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure?'),
                                    'method' => 'post',
                                ]
                            ]
                        );
                        
                        echo Html::tag('div', implode(' ', $buttons), ['class' => 'float-right']);
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
