<?php foreach ($block->value as $v) { ?>
    <img src="<?= Yii::$app->sr->image->thumb($v, [200, 400]) ?>">
<?php } ?>
