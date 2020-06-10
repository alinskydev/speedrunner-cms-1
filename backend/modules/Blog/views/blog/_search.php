<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="blog-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'search-form',
        ],
    ]); ?>
    
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'published_from')->textInput(['data-toggle' => 'datepicker']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'published_to')->textInput(['data-toggle' => 'datepicker']) ?>
        </div>
        <div class="col-md-3">
            <label>&nbsp;</label><br>
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>
