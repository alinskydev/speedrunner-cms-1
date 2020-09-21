<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use wbraganca\fancytree\FancytreeWidget;

$categories = json_decode($model->categories_tmp, JSON_UNESCAPED_UNICODE);
$data = selectCategories($data, $categories);

function selectCategories($data, $categories)
{
    $result = [];
    
    foreach ($data as $key => $d) {
        $d['selected'] = in_array($d['id'], $categories);
        $d['children'] = selectCategories($d['children'], $categories);
        
        $result[] = $d;
    }
    
    return $result;
}

?>

<div class="row">
    <div class="col-md-6">
        <div class="main-shadow">
            <div class="p-3 bg-primary text-white">
                <h5 class="m-0">
                    <?= Yii::t('app', 'Tree') ?>
                </h5>
            </div>
            
            <div class="p-3">
                <?= FancytreeWidget::widget([
                    'options' => [
                        'source' => $data,
                        'checkbox' => true,
                        'generateIds' => true,
                        'idPrefix' => 'id-',
                        'extensions' => [],
                        'select' => new JsExpression('function(event, data) {
                            categoriesValue = JSON.parse($("#product-categories_tmp").val());
                            id = parseInt(data.node.data.id);
                            
                            if (categoriesValue.includes(id)) {
                                categoriesValue.splice(categoriesValue.indexOf(id), 1);
                            } else {
                                categoriesValue.push(id);
                            };
                            
                            $("#product-categories_tmp").val(JSON.stringify(categoriesValue)).change();
                        }'),
                    ],
                ]); ?>
                
                <?= $form->field($model, 'categories_tmp', ['template' => '{input}'])->hiddenInput([
                    'data-action' => Yii::$app->urlManager->createUrl(['product/product/specifications']),
                ]) ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="main-shadow">
            <div class="p-3 bg-primary text-white">
                <h5 class="m-0">
                    <?= Yii::t('app', 'Specifications') ?>
                </h5>
            </div>
            
            <div class="p-3">
                <div id="specifications-wrapper"></div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el, action, sendData;
        
        $(document).on('change', '#product-categories_tmp', function() {
            el = $(this);
            action = el.data('action');
            sendData = {
                id: '<?= ArrayHelper::getValue($model, 'id') ?>',
                categories: el.val()
            };
            
            $.get(action, sendData, function(data) {
                $('#specifications-wrapper').html(data.specifications);
                $('#variation-specification').html(data.variations).trigger('change');
            });
        });
        
        $(document).on('change', '#variation-specification', function() {
            $('#variation-option').html($(this).find(':selected').data('options') ? $(this).find(':selected').data('options') : null);
        });
        
        $('#product-categories_tmp').trigger('change');
    });
</script>

