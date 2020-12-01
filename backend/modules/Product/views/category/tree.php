<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use wbraganca\fancytree\FancytreeWidget;

$this->title = Yii::t('app', 'Product categories');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::a(
        Html::tag('i', null, ['class' => 'fas fa-plus-square']) . Yii::t('app', 'Create'),
        ['tree'],
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>
</h2>

<div class="row">
    <div class="col-md-8">
        <div id="nav-item-content"></div>
    </div>

    <div class="col-md-4">
        <div class="main-shadow">
            <div class="p-3 bg-primary text-white">
                <h5 class="m-0">
                    <?= Yii::t('app', 'Tree') ?>
                </h5>
            </div>
            
            <div class="p-3">
                <div class="form-group">
                    <?= Html::textInput('fancytree_search', null, [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Search'),
                    ]) ?>
                </div>
                
                <?= FancytreeWidget::widget([
                    'pluginOptions' => [
                        'data-action_create' => Yii::$app->urlManager->createUrl(['product/category/create']),
                        'data-action_update' => Yii::$app->urlManager->createUrl(['product/category/update']),
                        'data-action_expand' => Yii::$app->urlManager->createUrl(['product/category/expand']),
                        'data-action_move' => Yii::$app->urlManager->createUrl(['product/category/move']),
                    ],
                    'options' => [
                        'source' => $data,
                        'extensions' => ['dnd', 'filter'],
                        'init' => new JsExpression('function(event, data) {
                            $("#nav-item-content").load(data.tree.$div.data("action_create"));
                        }'),
                        'activate' => new JsExpression('function(event, data) {
                            $("#nav-item-content").load(data.tree.$div.data("action_update") + "?id=" + data.node.data.id);
                        }'),
                        'collapse' => new JsExpression('function(event, data) {
                            $.get(data.tree.$div.data("action_expand"), {
                                id: data.node.data.id
                            });
                        }'),
                        'expand' => new JsExpression('function(event, data) {
                            $.get(data.tree.$div.data("action_expand"), {
                                id: data.node.data.id
                            });
                        }'),
                        'dnd' => [
                            'preventVoidMoves' => true,
                            'preventRecursiveMoves' => true,
                            'autoExpandMS' => 400,
                            'dragStart' => new JsExpression('function(node, data) {
                                return true;
                            }'),
                            'dragEnter' => new JsExpression('function(node, data) {
                                return true;
                            }'),
                            'dragDrop' => new JsExpression('function(node, data) {
                                $.get(data.tree.$div.data("action_move"), {
                                    item: data.otherNode.data.id,
                                    action: data.hitMode,
                                    second: node.data.id
                                }, function() {
                                    data.otherNode.moveTo(node, data.hitMode);
                                });
                            }'),
                        ],
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
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tree;
        
        $('input[name="fancytree_search"]').on('keyup', function(e) {
            tree = $.ui.fancytree.getTree();
            tree.filterBranches.call(tree, $(this).val(), {});
        });
    });
</script>
