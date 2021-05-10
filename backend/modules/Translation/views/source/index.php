<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\grid\GridView;

$this->title = Yii::t('app', 'Translations');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
    <div class="float-right">
        <?= Html::a(
            Html::tag('i', null, ['class' => 'fas fa-file-alt']) . Yii::t('app', 'Import'),
            '#',
            [
                'class' => 'btn btn-info btn-icon',
                'data-sr-trigger' => 'ajax-button',
                'data-sr-url' => Yii::$app->urlManager->createUrl(['translation/source/import']),
                'data-sr-wrapper' => '#main-modal',
                'data-sr-callback' => '$("#main-modal").modal()',
            ]
        ); ?>
        
        <?= Html::a(
            Html::tag('i', null, ['class' => 'fas fa-file-alt']) . Yii::t('app', 'Export'),
            '#',
            [
                'class' => 'btn btn-success btn-icon',
                'data-sr-trigger' => 'ajax-button',
                'data-sr-url' => Yii::$app->urlManager->createUrl(['translation/source/export']),
                'data-sr-wrapper' => '#main-modal',
                'data-sr-callback' => '$("#main-modal").modal()',
            ]
        ); ?>
    </div>
</h2>

<div class="main-shadow p-3">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            'category',
            'message:ntext',
            [
                'attribute' => 'translations_tmp',
                'format' => 'raw',
                'value' => fn ($model) => ArrayHelper::getValue($model, 'currentTranslation.translation'),
                'contentOptions' => [
                    'style' => 'max-width: 300px; white-space: normal;',
                ],
            ],
            [
                'attribute' => 'has_translation',
                'format' => 'boolean',
                'value' => fn ($model) => (bool)ArrayHelper::getValue($model, 'currentTranslation.translation'),
            ],
            [
                'class' => 'backend\widgets\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
