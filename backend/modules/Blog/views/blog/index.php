<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\framework\grid\GridView;
use kartik\select2\Select2;
use yii\web\JsExpression;

use backend\modules\Blog\models\BlogTag;

$this->title = Yii::t('app', 'Blogs');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::a(
        Html::tag('i', null, ['class' => 'fas fa-plus-square']) . Yii::t('app', 'Create'),
        ['create'],
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>
</h2>

<div class="main-shadow p-3">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $modelSearch,
        'columns' => [
            [
                'class' => 'common\components\framework\grid\CheckboxColumn',
            ],
            [
                'header' => false,
                'format' => 'raw',
                'filter' => false,
                'value' => fn ($model) => Html::img(Yii::$app->sr->image->thumb($model->image, [40, 40], 'resize')),
                'headerOptions' => [
                    'style' => 'width: 65px;'
                ],
            ],
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            'name',
            [
                'attribute' => 'slug',
                'format' => 'raw',
                'value' => fn ($model) => Html::a($model->slug, Yii::$app->urlManagerFrontend->createUrl(['blog/view', 'slug' => $model->slug]), ['target' => '_blank']),
            ],
            [
                'attribute' => 'category_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $modelSearch,
                    'attribute' => 'category_id',
                    'data' => [$modelSearch->category_id => ArrayHelper::getValue($modelSearch->category, 'name')],
                    'options' => ['placeholder' => ' '],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['items-list/blog-categories']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => fn ($model) => ArrayHelper::getValue($model->category, 'name'),
            ],
            [
                'attribute' => 'tag_id',
                'label' => $modelSearch->getAttributeLabel('tags_tmp'),
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $modelSearch,
                    'attribute' => 'tag_id',
                    'data' => [$modelSearch->tag_id => ArrayHelper::getValue(BlogTag::findOne($modelSearch->tag_id), 'name')],
                    'options' => ['placeholder' => ' '],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl(['items-list/blog-tags']),
                            'dataType' => 'json',
                            'delay' => 300,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),
                'value' => 'tagsColumn',
            ],
            [
                'attribute' => 'published',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'data-toggle' => 'datepicker'
                ]
            ],
            'created',
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
