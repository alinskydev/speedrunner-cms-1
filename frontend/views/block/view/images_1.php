<?php foreach ($value as $v) { ?>
    <img src="<?= Yii::$app->services->image->thumb($v, [150, 150]) ?>">
<?php } ?>
