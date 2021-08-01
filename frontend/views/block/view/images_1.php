<?php foreach ($value as $v) { ?>
    <img src="<?= Yii::$app->helpers->image->thumb($v, [150, 150]) ?>">
<?php } ?>
