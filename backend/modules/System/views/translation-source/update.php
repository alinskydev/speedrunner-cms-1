<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use backend\modules\System\models\SystemLanguage;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {message}', ['message' => $model->message]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translation Sources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

$active_langs = SystemLanguage::find()->where(['active' => 1])->column();

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
                <?php
                    foreach ($model->getActiveTranslations($active_langs) as $t) {
                        echo $form->field($model, 'translations_tmp['.$t->counter.']')
                            ->textarea(['rows' => 6, 'value' => $t->translation])
                            ->label($t->language->name);
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
