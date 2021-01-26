<?php

use yii\widgets\LinkPager;

$this->title = !$category->isNewRecord ? $category->name : Yii::t('app', 'Catalog');

if (!$category->isNewRecord) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog'), 'url' => ['product/catalog', 'url' => null]];
    
    foreach ($parent_categories as $p) {
        $this->params['breadcrumbs'][] = ['label' => $p->name, 'url' => ['product/catalog', 'url' => $p->url()]];
    }
}

$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $category->name ?>
