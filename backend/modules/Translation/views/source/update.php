<?php

use yii\helpers\Html;
use backend\widgets\crud\UpdateWidget;

$this->title = Yii::$app->helpers->html->pageTitle($model, 'message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

foreach ($model->service->activeTranslations() as $t) {
    $attributes[] = [
        'name' => "translations_tmp[$t->language]",
        'type' => 'text_area',
        'container_options' => [
            'template' => "{beginLabel} {$t->lang->name} {endLabel} {input}{hint}{error}",
        ],
        'options' => [
            'value' => $t->translation,
        ],
    ];
}

echo UpdateWidget::widget([
    'model' => $model,
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => $attributes ?? [],
        ],
    ],
]);
