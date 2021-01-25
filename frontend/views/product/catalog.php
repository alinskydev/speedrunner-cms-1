<?php

use yii\widgets\LinkPager;

$this->title = !$cat->isNewRecord ? $cat->name : Yii::t('app', 'Catalog');

if (!$cat->isNewRecord) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog'), 'url' => ['product/catalog', 'url' => null]];
    
    foreach ($parent_cats as $p) {
        $this->params['breadcrumbs'][] = ['label' => $p->name, 'url' => ['product/catalog', 'url' => $p->url()]];
    }
}

$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $cat->name ?>
