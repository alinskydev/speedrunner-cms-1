<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'Comment: {id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'update-form'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->helpers->html->saveButtons(['save_update', 'save']) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    <?= Yii::t('app', 'Information') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-information" class="tab-pane active">
                <?= DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table'],
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'blog_id',
                            'value' => fn($model) => ArrayHelper::getValue($model->blog, 'name'),
                        ],
                        [
                            'attribute' => 'user_id',
                            'value' => fn($model) => ArrayHelper::getValue($model->user, 'username'),
                        ],
                        'text:ntext',
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function($model) use ($form) {
                                return $form->field($model, 'status', [
                                    'template' => '{input}{hint}{error}',
                                    'options' => ['class' => 'm-0'],
                                ])->dropDownList(ArrayHelper::getColumn($model->enums->statuses(), 'label'));
                            },
                        ],
                        'created_at',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
