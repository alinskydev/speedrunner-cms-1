<?php foreach ($value as $v) { ?>
    <img src="<?= Yii::$app->helpers->image->thumb($v, [200, 400]) ?>">
<?php } ?>
