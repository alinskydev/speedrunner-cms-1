<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\crud\RelationsWidget;
use speedrunner\widgets\TranslationActiveField;

use backend\modules\Order\models\OrderProduct;

$is_block_disabled = !$model->isNewRecord && $model->status != 'new';

echo RelationsWidget::widget([
    'form' => $form,
    'relations' => ArrayHelper::merge($model->products, [new OrderProduct()]),
    'table_options' => [
        'class' => 'table table-relations ' . ($is_block_disabled ? 'disabled-block' : ''),
    ],
    'name_prefix' => 'ProductSpecification[options_tmp]',
    'attributes' => [
        [
            'name' => 'product_id',
            'type' => 'function',
            'value' => function ($form, $relation) use ($is_block_disabled) {
                if ($is_block_disabled) {
                    $result[] = $form->field($relation, 'product_id', [
                        'options' => ['class' => 'form-group mb-3'],
                    ])->textInput([
                        'value' => ArrayHelper::getValue($relation, 'product_json.name'),
                    ]);

                    if ($variation_name = ArrayHelper::getValue($relation, 'product_json.variation.name')) {
                        $result[] = $form->field($relation, 'variation_id')->textInput([
                            'value' => $variation_name,
                        ]);
                    }
                } else {
                    $relation_id = $relation->isNewRecord ? '__key__' : $relation->id;
                    
                    $result[] = $form->field($relation, 'product_id', [
                        'enableClientValidation' => false,
                        'options' => ['class' => 'form-group mb-3'],
                    ])->dropDownList(
                        [$relation->product_id => ArrayHelper::getValue($relation, 'product.name')],
                        [
                            'name' => "Order[products_tmp][$relation_id][product_id]",
                            'id' => "select2-products-$relation_id",
                            'disabled' => $is_block_disabled,
                            'data-sr-trigger' => 'select2-ajax',
                            'data-url' => Yii::$app->urlManager->createUrl(['items-list/products']),

                            'data-variation-toggle' => true,
                            'data-variation-action' => Yii::$app->urlManager->createUrl(['product/product/variations']),
                            'data-variation-id' => $relation->variation_id,
                            'data-variation-name' => "Order[products_tmp][$relation_id][variation_id]",
                        ]
                    );

                    $result[] = Html::tag('div', null, ['class' => 'order-products-variation-wrapper']);
                }

                return implode('', $result);
            },
        ],
        'quantity' => 'text_input',
        [
            'name' => 'price',
            'type' => 'text_input',
            'options' => [
                'readonly' => true,
            ],
        ],
        [
            'name' => 'discount',
            'type' => 'text_input',
            'options' => [
                'readonly' => true,
            ],
        ],
        [
            'name' => 'total_price',
            'type' => 'text_input',
            'options' => [
                'readonly' => true,
            ],
        ],
    ],
]);

?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let el, action, sendData;

        $(document).on('change', '[data-variation-toggle]', function() {
            el = $(this);
            action = el.data('variation-action');

            sendData = {
                id: el.val(),
                variation_id: el.data('variation-id'),
                name: el.data('variation-name'),
            };

            $.get(action, sendData, (data) => {
                $($(this).closest('tr').find('.order-products-variation-wrapper')).html(data);
            });
        });

        <?php if (!$is_block_disabled) { ?>
            $('[data-variation-toggle]').trigger('change');
        <?php } ?>
    });
</script>