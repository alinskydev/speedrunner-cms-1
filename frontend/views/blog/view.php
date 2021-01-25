<?php

(new \backend\modules\Seo\services\SeoMetaService($model))->register();

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['blog/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $model->name ?>
