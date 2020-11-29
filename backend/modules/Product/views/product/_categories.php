<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use wbraganca\fancytree\FancytreeWidget;

$categories = ArrayHelper::getColumn($model->categories, 'id');
$data = selectCategories($data, $categories);

function selectCategories($data, $categories)
{
    foreach ($data as $key => $d) {
        $result[] = [
            'key' => $d['id'],
            'title' => $d['title'],
            'selected' => in_array($d['id'], $categories),
            'expanded' => true,
            'children' => isset($d['children']) ? selectCategories($d['children'], $categories) : [],
        ];
    }
    
    return $result ?? [];
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
                <?= $form->field($model, 'categories_tmp', [
                    'template' => '{label}{error}<br>',
                    'options' => ['class' => 'mb-0'],
                ])->hiddenInput(['value' => '']) ?>
                
                <div class="form-group">
                    <?= Html::textInput('fancytree_search', null, [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Search'),
                    ]) ?>
                </div>
                
                <?= FancytreeWidget::widget([
                    'pluginOptions' => [
                        'data-action' => Yii::$app->urlManager->createUrl(['product/product/specifications']),
                        'data-id' => ArrayHelper::getValue($model, 'id'),
                    ],
                    'options' => [
                        'source' => $data,
                        'checkbox' => true,
                        'extensions' => ['filter'],
                        'init' => new JsExpression('function(event, data) {
                            data.tree.options.select(event, data);
                        }'),
                        'select' => new JsExpression('function(event, data) {
                            selectedNodes = data.tree.getSelectedNodes();
                            nodesArr = [];
                            
                            for (key in selectedNodes) {
                                nodesArr.push(selectedNodes[key]["key"]);
                            }
                            
                            el = data.tree.$div;
                            action = el.data("action");
                            sendData = {
                                id: el.data("id"),
                                categories: nodesArr
                            };
                            
                            $.get(action, sendData, function(data) {
                                $("#specifications-wrapper").html(data.specifications);
                                $("#variation-specification").html(data.variations).trigger("change");
                            });
                        }'),
                        'filter' => [
                            'autoExpand' => true,
                            'highlight' => false,
                            'mode' => 'hide',
                        ],
                    ],
                ]); ?>
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
        var tree;
        
        $('input[name="fancytree_search"]').on('keyup', function(e) {
            tree = $.ui.fancytree.getTree();
            tree.filterNodes.call(tree, $(this).val(), {});
        });
        
//        ----------------------------------------------------------------------
        
        $(document).on('change', '#variation-specification', function() {
            $('#variation-option').html($(this).find(':selected').data('options') ? $(this).find(':selected').data('options') : null);
        });
        
        $(document).on('submit', '#update-form', function() {
            tree = $.ui.fancytree.getTree();
			tree.generateFormElements('Product[categories_tmp][]');
		});
    });
</script>

