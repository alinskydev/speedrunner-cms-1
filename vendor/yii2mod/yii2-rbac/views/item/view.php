<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\DetailView;
use yii2mod\rbac\RbacAsset;

RbacAsset::register($this);

$this->title = Yii::t('app', 'View: {name}', ['name' => $model->name]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('yii2mod.rbac', 'RBAC'), 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii2mod.rbac', $this->context->labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-general">
                    <?= Yii::t('app', 'General') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-assignment">
                    <?= Yii::t('app', 'Assignment') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-general" class="tab-pane active">
                <?= DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-bordered m-0'],
                    'attributes' => [
                        'name',
                        'description:ntext',
                        'ruleName',
                        'data:ntext',
                    ],
                ]); ?>
            </div>
            
            <div id="tab-assignment" class="tab-pane fade">
                <?= $this->render('../_dualListBox', [
                    'opts' => Json::htmlEncode([
                        'items' => $model->getItems(),
                    ]),
                    'assignUrl' => ['assign', 'id' => $model->name],
                    'removeUrl' => ['remove', 'id' => $model->name],
                ]); ?>
            </div>
        </div>
    </div>
</div>
