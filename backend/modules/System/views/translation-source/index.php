<?php

use yii\helpers\Html;
use common\components\framework\grid\GridView;

use backend\modules\System\models\SystemLanguage;

$this->title = Yii::t('app', 'Translation Sources');
$this->params['breadcrumbs'][] = ['label' => $this->title];

$active_langs = SystemLanguage::find()->where(['active' => 1])->column();

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
                'value' => function ($model) use ($active_langs) {
                    return $model->getTranslationsColumn($active_langs);
                },
                'format' => 'raw',
                'contentOptions' => [
                    'style' => 'max-width: 300px; white-space: normal;',
                ],
            ],
            [
                'class' => 'common\components\framework\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
