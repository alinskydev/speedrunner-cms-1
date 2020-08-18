<?php

Yii::$app->sr->seo->registerMeta($model);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['blog/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $model->name ?>
