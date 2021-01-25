<?php foreach ($value as $v) { ?>
    <img src="<?= Yii::$app->services->image->thumb($v, [200, 400]) ?>">
<?php } ?>
