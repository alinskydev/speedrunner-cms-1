<?php foreach ($block->images as $img) { ?>
    <img src="<?= Yii::$app->sr->image->thumb($img->image, [200, 400]) ?>">
<?php } ?>
