<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\crud\RelationsWidget;
use speedrunner\widgets\TranslationActiveField;

use backend\modules\Product\models\ProductVariation;

echo RelationsWidget::widget([
    'form' => $form,
    'relations' => ArrayHelper::merge($model->variations, [new ProductVariation()]),
    'name_prefix' => 'Product[variations_tmp]',
    'attributes' => [
        [
            'name' => 'name',
            'type' => 'text_input',
            'container_options' => [
                'class' => TranslationActiveField::className(),
            ],
        ],
        'sku' => 'text_input',
        'price' => 'text_input',
        'discount' => 'text_input',
        'quantity' => 'text_input',
        [
            'name' => false,
            'type' => 'function',
            'value' => function ($form, $relation) {
                if ($relation->isNewRecord) return;

                return Html::button(
                    Html::tag('i', null, ['class' => 'fas fa-images']),
                    [
                        'class' => 'btn btn-primary',
                        'data-sr-trigger' => 'ajax-button',
                        'data-sr-url' => Yii::$app->urlManager->createUrl(['product/variation/update', 'id' => $relation->id]),
                        'data-sr-wrapper' => '#main-modal',
                        'data-sr-callback' => '$("#main-modal").modal()',
                    ]
                );
            },
        ],
    ],
]);
