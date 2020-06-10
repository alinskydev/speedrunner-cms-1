<?php foreach ($block->value as $value) { ?>
    <h4><?= $value['title'] ?></h4>
    <pre><?= $value['short_description'] ?></pre>
    <div><?= $value['full_description'] ?></div>
<?php } ?>
