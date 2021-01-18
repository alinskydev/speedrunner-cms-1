<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;
use vova07\imperavi\Widget;

use backend\modules\Order\models\OrderProduct;

$this->title = Yii::t('app', 'View: {id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'update-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->sr->html->updateButtons(['save_reload', 'save']) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    <?= Yii::t('app', 'Information') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-products">
                    <?= Yii::t('app', 'Products') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content">
            <div id="tab-information" class="tab-pane active">
                <div class="main-shadow p-3">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table m-0'],
                        'attributes' => [
                            [
                                'label' => Yii::t('app', 'Total'),
                                'value' => null,
                                'captionOptions' => ['class' => 'bg-primary text-white', 'colspan' => 2],
                                'contentOptions' => ['class' => 'd-none'],
                            ],
                            'id',
                            'total_quantity',
                            'total_price',
                            [
                                'attribute' => 'delivery_type',
                                'format' => 'raw',
                                'value' => function ($model) use ($form) {
                                    return $form->field($model, 'delivery_type', [
                                        'template' => '{input}{hint}{error}',
                                        'options' => ['class' => 'm-0'],
                                    ])->dropDownList(ArrayHelper::getColumn($model->deliveryTypes(), 'label'));
                                }
                            ],
                            [
                                'attribute' => 'delivery_price',
                                'format' => 'raw',
                                'value' => function ($model) use ($form) {
                                    return $form->field($model, 'delivery_price', [
                                        'template' => '{input}{hint}{error}',
                                        'options' => ['class' => 'm-0'],
                                    ])->textInput();
                                }
                            ],
                            [
                                'attribute' => 'payment_type',
                                'format' => 'raw',
                                'value' => function ($model) use ($form) {
                                    return $form->field($model, 'payment_type', [
                                        'template' => '{input}{hint}{error}',
                                        'options' => ['class' => 'm-0'],
                                    ])->dropDownList(ArrayHelper::getColumn($model->paymentTypes(), 'label'));
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function ($model) use ($form) {
                                    return $form->field($model, 'status', [
                                        'template' => '{input}{hint}{error}',
                                        'options' => ['class' => 'm-0'],
                                    ])->dropDownList(ArrayHelper::getColumn($model->statuses(), 'label'));
                                }
                            ],
                            'created',
                            'updated',
                        ],
                    ]) ?>
                </div>
                
                <div class="main-shadow p-3 mt-3">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table m-0'],
                        'attributes' => [
                            [
                                'label' => Yii::t('app', 'Person'),
                                'value' => null,
                                'captionOptions' => ['class' => 'bg-primary text-white', 'colspan' => 2],
                                'contentOptions' => ['class' => 'd-none'],
                            ],
                            [
                                'attribute' => 'user_id',
                                'value' => fn ($model) => ArrayHelper::getValue($model->user, 'username'),
                            ],
                            'full_name',
                            'phone',
                            'email',
                            'address:ntext',
                        ],
                    ]) ?>
                </div>
            </div>
            
            <div id="tab-products" class="tab-pane fade">
                <?= $this->render('_products', [
                    'model' => $model,
                    'product_mdl' => new OrderProduct(),
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
