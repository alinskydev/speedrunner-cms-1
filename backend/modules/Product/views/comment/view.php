<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'Comment: {id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'edit-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::submitButton(
        Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-general">
                    <?= Yii::t('app', 'General') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-general" class="tab-pane active">
                <?= DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-bordered'],
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'product_id',
                            'value' => function ($model) {
                                return $model->product ? $model->product->name : null;
                            },
                        ],
                        [
                            'attribute' => 'user_id',
                            'value' => function ($model) {
                                return $model->user ? $model->user->username : null;
                            },
                        ],
                        'text:ntext',
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model) use ($form) {
                                return $form->field($model, 'status', [
                                    'template' => '{input}{hint}{error}',
                                    'options' => ['class' => 'm-0'],
                                ])->dropDownList(
                                    ArrayHelper::getColumn(Yii::$app->params['comment_statuses'], function ($value) {
                                        return Yii::t('app', $value);
                                    })
                                );
                            },
                        ],
                        'created',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
