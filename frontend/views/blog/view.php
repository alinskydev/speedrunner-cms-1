<?php

(new \backend\modules\Seo\services\SeoMetaService($model))->register();

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blogs'), 'url' => ['blog/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $model->name ?>
