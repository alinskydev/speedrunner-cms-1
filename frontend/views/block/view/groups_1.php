<?php foreach ($block->value as $value) { ?>
    <h4><?= $value['title'] ?></h4>
    <pre><?= $value['description'] ?></pre>
    <img src="<?= $value['image'] ?>">
<?php } ?>
