<?php foreach ($block->value as $v) { ?>
    <img src="<?= Yii::$app->sr->image->thumb($v, [150, 150], 'resize') ?>">
<?php } ?>
