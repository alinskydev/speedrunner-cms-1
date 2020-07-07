<?php foreach ($value as $v) { ?>
    checked: <?= $v['is_available'] ?><br>
    <img src="<?= $v['image'] ?>">
<?php } ?>