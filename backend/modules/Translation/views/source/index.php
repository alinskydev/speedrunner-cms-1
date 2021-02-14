<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use speedrunner\widgets\grid\GridView;

use backend\modules\System\models\SystemLanguage;

$this->title = Yii::t('app', 'Translations');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
</h2>

<div class="main-shadow p-3">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $modelSearch,
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
                'class' => 'speedrunner\widgets\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
