<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zzz Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'edit-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?php
        $buttons = [
            Html::button(
                Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save & reload'),
                ['class' => 'btn btn-info btn-icon', 'data-toggle' => 'save-reload']
            ),
            Html::submitButton(
                Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
                ['class' => 'btn btn-primary btn-icon']
            ),
        ];
        
        echo $this->title . Html::tag('div', implode(' ', $buttons), ['class' => 'float-right']);
    ?>
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
                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'slug')->textInput() ?>
                
                <?= $form->field($model, 'image')->widget(ElFinderInput::className(), [
                    'connectorRoute' => '/connection/elfinder-file-upload',
                ]) ?>
                
                <?= $form->field($model, 'description')->widget(Widget::className(), [
                    'settings' => [
                        'imageUpload' => Yii::$app->urlManager->createUrl('connection/editor-image-upload'),
                        'imageManagerJson' => Yii::$app->urlManager->createUrl('connection/editor-images'),
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
