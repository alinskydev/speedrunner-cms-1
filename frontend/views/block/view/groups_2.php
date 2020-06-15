<?php foreach ($block->value as $v) { ?>
    <h4><?= $v['title'] ?></h4>
    <pre><?= $v['description'] ?></pre>
<?php } ?>