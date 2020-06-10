<?php

use yii\widgets\ListView;
use yii\widgets\LinkPager;

$this->title = Yii::t('app', 'Blogs');

?>

<div class="site-index">
    <div class="body-content">
        <div class="row">
            <?= ListView::widget([
                'dataProvider' => $blogs,
                'itemView' => '_blog',
                'options' => [
                    'tag' => false,
                ],
                'itemOptions' => [
                    'tag' => false,
                ],
                'viewParams' => [],
                'layout' => '{items}',
            ]) ?>
        </div>
        
        <div class="row">
            <?= LinkPager::widget([
                'pagination' => $blogs->pagination,
                'prevPageLabel' => '<',
                'nextPageLabel' => '>',
            ]); ?>
        </div>
    </div>
</div>
