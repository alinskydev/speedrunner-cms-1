<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use wbraganca\fancytree\FancytreeWidget;

$this->title = Yii::t('app', 'Product Categories');
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
                <?= FancytreeWidget::widget([
                    'options' => [
                        'source' => $data,
                        'extensions' => ['dnd'],
                        'init' => new JsExpression('function(event, data, flag) {
                            $("#nav-item-content").load("' . Yii::$app->urlManager->createUrl([
                                'product/category/create'
                            ]) . '");
                        }'),
                        'collapse' => new JsExpression('function(event, data) {
                            $.get("' . Yii::$app->urlManager->createUrl(['product/category/expand-status']) . '", {
                                item: data.node.data.id
                            }, function() {});
                        }'),
                        'expand' => new JsExpression('function(event, data) {
                            $.get("' . Yii::$app->urlManager->createUrl(['product/category/expand-status']) . '", {
                                item: data.node.data.id
                            }, function() {});
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
                                $.get("' . Yii::$app->urlManager->createUrl(['product/category/move']) . '", {
                                    item: data.otherNode.data.id,
                                    action: data.hitMode,
                                    second: node.data.id
                                }, function() {
                                    data.otherNode.moveTo(node, data.hitMode);
                                });
                            }'),
                        ],
                        'activate' => new JsExpression('function(event, data) {
                            $("#nav-item-content").load("' . Yii::$app->urlManager->createUrl([
                                'product/category/update'
                            ]) . '?id=" + data.node.data.id);
                        }'),
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
