<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\crud\RelationsWidget;
use speedrunner\widgets\TranslationActiveField;

use backend\modules\Product\models\ProductSpecificationOption;

echo RelationsWidget::widget([
    'form' => $form,
    'relations' => ArrayHelper::merge($model->options, [new ProductSpecificationOption()]),
    'name_prefix' => 'ProductSpecification[options_tmp]',
    'attributes' => [
        [
            'name' => 'name',
            'type' => 'text_input',
            'container_options' => [
                'class' => TranslationActiveField::className(),
            ],
        ],
    ],
]);
