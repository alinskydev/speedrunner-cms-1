<?php

use yii\widgets\ListView;
use yii\widgets\LinkPager;

$this->title = $cat ? $cat->name : Yii::t('app', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $cat->name ?>
