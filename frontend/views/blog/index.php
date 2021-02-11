<?php

use yii\widgets\LinkPager;

$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php foreach ($blogs->getModels() as $b) { ?>
    <?= $b->name ?>
<?php } ?>

<?= LinkPager::widget([
    'pagination' => $blogs->pagination,
    'prevPageLabel' => '<',
    'nextPageLabel' => '>',
]); ?>
