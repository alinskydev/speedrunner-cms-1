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
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-products">
                    <?= Yii::t('app', 'Products') ?>
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
                        [
                            'label' => Yii::t('app', 'Total'),
                            'value' => null,
                            'captionOptions' => ['class' => 'bg-primary text-white', 'colspan' => 2],
                            'contentOptions' => ['class' => 'd-none'],
                        ],
                        'id',
                        [
                            'attribute' => 'delivery_type',
                            'format' => 'raw',
                            'value' => function ($model) use ($form) {
                                return $form->field($model, 'delivery_type', [
                                    'template' => '{input}{hint}{error}',
                                    'options' => ['class' => 'm-0'],
                                ])->dropDownList($model->deliveryTypes());
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
                                ])->dropDownList($model->paymentTypes());
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model) use ($form) {
                                return $form->field($model, 'status', [
                                    'template' => '{input}{hint}{error}',
                                    'options' => ['class' => 'm-0'],
                                ])->dropDownList(ArrayHelper::getColumn($model->statuses(), function ($value) {
                                    return $value['label'];
                                }));
                            }
                        ],
                        'total_quantity',
                        'total_price',
                        'created',
                        'updated',

                        [
                            'label' => Yii::t('app', 'Person'),
                            'value' => null,
                            'captionOptions' => ['class' => 'bg-primary text-white', 'colspan' => 2],
                            'contentOptions' => ['class' => 'd-none'],
                        ],
                        [
                            'attribute' => 'user_id',
                            'value' => function ($model) {
                                return $model->user ? $model->user->username : null;
                            }
                        ],
                        'full_name',
                        'phone',
                        'email',
                        'address:ntext',
                        'city',
                    ],
                ]) ?>
            </div>
            
            <div id="tab-products" class="tab-pane fade">
                <?= $this->render('_products', [
                    'model' => $model,
                    'product_mdl' => new OrderProduct,
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
