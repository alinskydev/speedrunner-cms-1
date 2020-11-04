<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'update-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->sr->html->updateButtons(['save_reload', 'save']) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    <?= Yii::t('app', 'Information') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-seo-meta">
                    <?= Yii::t('app', 'SEO meta') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-information" class="tab-pane active">
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
            
            <div id="tab-seo-meta" class="tab-pane fade">
                <?= $this->render('@backend/modules/Seo/views/meta/meta', [
                    'seo_meta' => Yii::$app->sr->seo->getMeta($model),
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
